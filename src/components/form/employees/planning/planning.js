(() => {
  return {
    props: {
      source: {
        type: Object
      }
    },
    data(){
      return {
        currentYear: moment().format('YYYY'),
        selected: '',
        events: [],
        isLoading: true,
        daysRange: [],
        employes: appui.app.employees,
        originalHours: 0,
        currentIdPlanning: ''
      }
    },
    computed: {
      dayText(){
        return this.selected ? moment(this.selected).format('dddd	DD MMMM YYYY') : '';
      },
      formSource(){
        return {events: this.events.slice()}
      },
      nom(){
        return bbn.fn.get_field(this.employes, 'value', this.source.id_employe, 'text');
      }
    },
    methods: {
      changeSelected(val){
        this.selected = val;
      },
      addEvent(){
        this.$refs.table.insert({}, {
          title: bbn._('Ajouter'),
          height: 200,
          width: 600
        });
      },
      editEvent(row, obj, idx){
        this.$refs.table.edit(row, {
          title: bbn._('Modifier'),
          height: 200,
          width: 600
        }, idx);
      },
      removeEvent(row, obj, idx){
        this.confirm(bbn._('Êtes-vous sûr de bien vouloir supprimer cet élément?'), () => {
          let idx = bbn.fn.search(this.events, row);
          if ( idx !== -1 ){
            this.events.splice(idx, 1);
            appui.success(bbn._('Supprimé'));
            this.$refs.table.updateData();
          }
        });
      },
      getTitle(d) {
        let ret = '',
            tmp = [];
        if ( d.events && d.events.length ){
          bbn.fn.each(d.events, (e, i) => {
            if ( !e.holiday_id ){
              let idx = bbn.fn.search(tmp, 'id', 'e.id_employe');
              if ( idx === -1 ){
                tmp.push({
                  id: e.id_employe,
                  nom: bbn.fn.get_field(appui.app.employees, 'value', e.id_employe, 'text'),
                  hour: moment(e.end).diff(moment(e.start), 'minutes')
                });
              }
              else {
                tmp[idx].hour += moment(e.end).diff(moment(e.start), 'minutes');
              }
            }
          });
          tmp = bbn.fn.order(tmp, 'nom', 'ASC');
          bbn.fn.each(tmp, (t, i) => {
            ret += t.nom + ': ' + t.hour/60;
            if ( tmp[i + 1] ){
              ret += "\n";
            }
          });
        }
        return ret;
      },
      afterSubmit(d){
        if ( d.success ){
          this.closest('bbn-container').find('ami-hr-tab-entities').$refs.table.updateData();
          appui.success(bbn._('Enregistré'));
        }
        else {
          appui.error();
        }
      }
    },
    watch: {
      selected(newVal, oldVal){
        this.getRef('splitter').panes[1].collapsed = !newVal;
        if ( newVal ){
          this.$nextTick(() => {
            let ev = bbn.fn.filter(this.events, {
              logic: 'AND',
              conditions: [{
                field: 'start',
                operator: '>=',
                value: this.selected + ' 00:00:00'
              }, {
                field: 'end',
                operator: '<=',
                value: this.selected + ' 23:59:59'
              }, {
                field: 'id_employe',
                operator: '=',
                value: this.source.id_employe
              }]  
            });
            this.originalHours = ev.length ? ev[0].hour : 0;
            this.currentIdPlanning = ev.length ? ev[0].id_planning : 0;
            if ( this.$refs.table ){
              this.$refs.table.currentFilters = this.$refs.table.filters;
              this.$refs.table.updateData();
            }
          })
        }
      }
    },
    mounted(){
      if ( this.source.id_employe && this.source.id_entity ){
        this.post("data/entities/planning", {
          id_entity: this.source.id_entity,
          id_employe: this.source.id_employe
        }, (d) => {
          if ( d.data ){
            if ( d.data.length ){
              let start = moment(d.data[0].holiday_start),
                  end = moment(d.data[0].holiday_end).format('YYYY-MM-DD');
              while ( start.format('YYYY-MM-DD') <= end ){
                this.daysRange.push(start.format('YYYY-MM-DD'));
                start.add(1, 'd');
              }
              d.data = d.data.map((e, i) => {
                e.hour = moment(e.end).diff(moment(e.start), 'minutes') / 60;
                e.nom = bbn.fn.get_field(appui.app.employees, 'value', e.id_employe, 'text');
                return e;
              });
            }
            this.events = d.data;
            this.isLoading = false;
          }
        })
      }
    },
    components: {
      form: {
        template: `
<bbn-form :source="source.row"
          @success="success"
          ref="form"
>
  <div class="bbn-grid-fields bbn-padded">
    <label>` + bbn._('Employé') + `</label>
    <bbn-dropdown :source="employes"
                  v-model="source.row.id_employe"
                  required="required"
                  placeholder="` + bbn._('Choisir') + `"
                  :nullable="true"
    ></bbn-dropdown>
    <label>` + bbn._('Hour') + `</label>
    <div>
      <bbn-numeric v-model="source.row.hour"
                  :step="0.5"
                  :min="0.5"
                  required="required"
                  :decimals="1"
                  @mounted="setStartEnd"
      ></bbn-numeric>
    </div>
  </div>
</bbn-form>
        `,
        props: ['source'],
        data(){
          return {
            employes: appui.app.employees,
            planning: this.closest('bbn-container').find('ami-hr-form-employee-planning')
          }
        },
        methods: {
          setStartEnd(){
            let h = parseInt(this.source.row.hour),
                m = this.source.row.hour - h === 0.5 ? 30 : 0;
            this.$set(this.source.row, 'start', this.planning.selected + ' 08:00:00');
            this.$set(this.source.row, 'end', moment(this.source.row.start).add({hours: h, minutes: m}).format('YYYY-MM-DD HH:mm:ss'))
          },
          success(d){
            if ( this.planning.$refs.table.editedIndex === -1 ){
              this.planning.events.push(d);
            }
            this.planning.$refs.table.updateData();
            appui.success(bbn._('enregistré'));
          }
        },
        watch: {
          'source.row.hour'(newVal){
            this.setStartEnd();
          }
        },
        beforeMount(){
          this.$set(this.source.row, 'id_planning', this.planning.currentIdPlanning);
        }
      }
    }
  }
})();