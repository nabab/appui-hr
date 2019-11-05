(() => {
  return {
    props: ['source'],
    data(){
      return {
        employes: appui.app.employees
      }
    },
    computed: {
      planning(){
        return this.closest('appui-hr-tab-planning')
      },
      currentDay(){
        return this.planning && this.planning.selected ? this.planning.selected : ''
      },
      toJSON(){
        return this.planning ? !!this.planning.fromJSON : null
      },
      isEditDisabled(){
        return this.planning ? !!this.planning.isBefore : false
      }
    },
    methods: {
      renderEntity(row){
        return `${row.entity_nom && row.entity_nom.length ? row.entity_nom + ' - ' : ''}${row.entity_adresse}`;
      },
      afterDelete(d){
        if ( d.success ){
          appui.success(bbn._('Deleted'));
          this.planning.calendarSelected.refresh();
        }
        else {
          appui.error();
        }
      },
      afterSave(d){
        if ( d.success ){
          appui.success(bbn._('Saved'));
          this.planning.calendarSelected.refresh();
        }
        else {
          appui.error();
        }
      },
      openCard(){
        bbn.fn.link(`${this.root}card/${this.source.id_employe}`);
      },
      add(){
        this.getRef('table').insert({}, {
          title: bbn._('Add'),
          height: 400,
          width: 600
        });
      },
      edit(row, obj, idx){
        this.getRef('table').edit(row, {
          title: bbn._('Edit'),
          height: 400,
          width: 600
        }, idx);
      },
      remove(row){
        this.confirm(bbn._('Are you sure you want to delete this element?'), () => {
          this.post(this.root + 'actions/planning/delete', {
            id: row.id,
            toJSON: this.toJSON,
            day: this.currentDay
          }, d => {
            if ( d.success ){
              appui.success(bbn._('Deleted'));
              this.planning.fullRefresh();
            }
            else {
              appui.error();
            }
          })
        });
      }
    },
    components: {
      form: {
        template: `
<bbn-form :action="root + 'actions/planning/' + (source.row.id ? 'update' : 'insert')"
          :data="source.data"
          :source="source.row"
          @success="afterSubmit"
          ref="form"
>
  <div class="bbn-grid-fields bbn-padded">
    <label>` + bbn._('Employe') + `</label>
    <bbn-dropdown :source="employes"
                  v-model="source.row.id_employe"
                  required="required"
    ></bbn-dropdown>
    <label>` + bbn._('Entity') + `</label>
    <bbn-autocomplete source="data/search"
                      v-model="source.row.id_entity"
                      source-text="text"
                      source-value="value"
                      ref="autocomplete"
                      required="required"
                      @mounted="setDataSource"
                      @change="fixAutocomplete"
    ></bbn-autocomplete>
    <label>` + bbn._('Hour') + `</label>
    <div>
      <bbn-numeric v-model="source.row.hour"
                  :step="0.5"
                  :min="0.5"
                  required="required"
                  :decimals="1"
      ></bbn-numeric>
    </div>
  </div>
</bbn-form>
        `,
        props: ['source'],
        data(){
          return {
            employes: appui.app.employees,
            root: appui.plugins['appui-hr'] + '/',
            dataSource: [{
              text: this.source.row.id_entity ? `${this.source.row.entity_nom && this.source.row.entity_nom.length ? this.source.row.entity_nom + ' - ' : ''}${this.source.row.entity_adresse}` : '',
              value: this.source.row.id_entity
            }]
          }
        },
        methods: {
          afterSubmit(d){
            if( d.success ){
              appui.success(bbn._('Saved'));
              this.closest('bbn-container').find('appui-hr-tab-planning').fullRefresh();
            }
            else {
              appui.error();
            }
          },
          setDataSource(){
            this.$nextTick(() => {
              this.getRef('autocomplete').widget.dataSource.data(this.dataSource);
              this.fixAutocomplete();
            });
          },
          fixAutocomplete(){
            setTimeout(() => {
              let idx = bbn.fn.search(this.getRef('autocomplete').widget.dataSource.data().toJSON(), 'value', this.source.row.id_entity);
              if ( idx > -1 ){
                this.getRef('autocomplete').widget.select(idx);
              }
            });
          }
        }
      }
    }
  };
})();