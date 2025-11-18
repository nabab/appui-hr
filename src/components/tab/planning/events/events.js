(() => {
  return {
    props: ['source'],
    data(){
      return {
        staff: appui.app.staffActive
      }
    },
    computed: {
      planning(){
        return this.closest('appui-hr-tab-planning')
      },
      currentDay(){
        return this.planning && this.planning.selected ? this.planning.selected : ''
      },
      isEditDisabled(){
        if ( !this.planning.hr.source.perms.write ){
          return true;
        }
        return this.planning ? !!this.planning.isBefore : false
      }
    },
    methods: {
      _remove(toPost){
        this.post(this.root + 'actions/planning/delete', toPost, d => {
          if ( d.success ){
            appui.success(bbn._('Deleted'));
            this.planning.fullRefresh();
          }
          else {
            appui.error();
          }
        });
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
          label: bbn._('Add') + ' - ' + this.planning.dayText,
          width: 600
        });
      },
      edit(row, obj, idx){
        this.getRef('table').edit(row, {
          label: bbn._('Edit') + ' - ' + this.planning.dayText,
          width: 600
        }, idx);
      },
      removeItem(row){
        let toPost = {
          id: row.id,
          day: this.currentDay
        };
        if ( row.recurring ){
          this.getPopup({
            label: bbn._('Attention'),
            content: '<div class="bbn-padding bbn-c">' + bbn._('What events do you want to delete?') + '</div>',
            buttons: [{
              text: bbn._('Cancel'),
              action: () => {
                this.getPopup().close();
              }
            }, {
              text: bbn._('Only this'),
              action: () => {
                toPost.delete = 'this';
                this._remove(toPost);
                this.getPopup().close();
              }
            }, {
              text: bbn._('All series'),
              action: () => {
                toPost.delete = 'all';
                this._remove(toPost);
                this.getPopup().close();
              }
            }, {
              text: bbn._('Future'),
              action: () => {
                toPost.delete = 'future';
                this._remove(toPost);
                this.getPopup().close();
              }
            }],
            closable: false,
            width: 300
          });
        }
        else {
          this.confirm(bbn._('Are you sure you want to delete this element?'), () => {
            this._remove(toPost);
          });
        }
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
          @submit="askEdit"
>
  <div class="bbn-grid-fields bbn-padding">
    <label>` + bbn._('Staff') + `</label>
    <bbn-dropdown :source="staff"
                  v-model="source.row.id_staff"
                  required="required"
    ></bbn-dropdown>
    <label>` + bbn._('Hours') + `</label>
    <div>
      <bbn-numeric v-model="source.row.hour"
                  :step="0.5"
                  :min="0.5"
                  :max="23.5"
                  required="required"
                  :decimals="1"
                  style="width: 6em"
      ></bbn-numeric>
    </div>
    <label>` + bbn._('Recurrence') + `</label>
    <div class="bbn-vmiddle">
      <bbn-switch v-model="source.row.recurring"
                  :value="1"
                  :novalue="0"
      ></bbn-switch>
    </div>
    <label></label>
    <div v-if="!!source.row.recurring">
      <div class="bbn-border bbn-radius bbn-flex-fill bbn-padding">
        <div class="bbn-grid-fields">
          <label>` + bbn._('Type') + `</label>
          <bbn-dropdown :source="frequencies"
                        v-model="source.row.type"
                        @change="resetRepeat()"
          ></bbn-dropdown>
          <label v-if="ifVisible('interval')">` + bbn._('Intervale') + `</label>
          <div v-if="ifVisible('interval')">
            <bbn-numeric v-model="source.row.interval"
                        :min="0"
                        style="width: 6em"
            ></bbn-numeric>
            <span class="bbn-left-space"
                  v-text="intervals[source.row.type]"
            ></span>
          </div>
          <label v-if="ifVisible('wd')">
            <span>` + bbn._('Days of the week') + `</span>
            <div v-if="source.row.type === 'monthly'"
                  class="bbn-p bbn-s bbn-i"
                  @click="showMonthDays = !showMonthDays"
            >` + bbn._('Days of the month') + `</div>
          </label>
          <div v-if="ifVisible('wd')">
            <div class="bbn-grid"
                style="grid-template-columns: repeat(7, 1fr)"
            >
              <div v-for="d in 7"
                  :class="['bbn-c', 'bbn-widget', 'bbn-p', 'bbn-radius', {'bbn-primary': source.row.wd.includes(d)}]"
                  v-text="getDayName(d)"
                  @click="addRemove('wd', d)"
              ></div>
            </div>
          </div>
          <label v-if="ifVisible('md')">
            <span>` + bbn._('Days of the month') + `</span>
            <div v-if="source.row.type === 'monthly'"
                  class="bbn-p bbn-s bbn-i"
                  @click="showMonthDays = !showMonthDays"
            >` + bbn._('Days of the week') + `</div>
          </label>
          <div v-if="ifVisible('md')">
            <div class="bbn-grid"
                style="grid-template-columns: repeat(9, 1fr)"
            >
              <div v-for="d in 31"
                  :class="['bbn-c', 'bbn-widget', 'bbn-p', 'bbn-radius', {'bbn-primary': source.row.md.includes(d)}]"
                  v-text="d"
                  @click="addRemove('md', d)"
              ></div>
            </div>
          </div>
          <label v-if="ifVisible('mw')">` + bbn._('Week of the month') + `</label>
          <div v-if="ifVisible('mw')">
            <div class="bbn-grid"
                style="grid-template-columns: repeat(6, 1fr)"
            >
              <div v-for="d in monthWeeks"
                  :class="['bbn-c', 'bbn-widget', 'bbn-p', 'bbn-radius', {'bbn-primary': source.row.mw.includes(d)}]"
                  v-text="d"
                  @click="addRemove('mw', d)"
              ></div>
            </div>
          </div>
          <label v-if="ifVisible('ym')">` + bbn._('Month') + `</label>
          <div v-if="ifVisible('ym')">
            <div class="bbn-grid"
                style="grid-template-columns: repeat(6, 1fr)"
            >
              <div v-for="m in 12"
                  :class="['bbn-c', 'bbn-widget', 'bbn-p', 'bbn-radius', {'bbn-primary': source.row.ym.includes(m)}]"
                  v-text="getMonthName(m)"
                  @click="addRemove('ym', m)"
              ></div>
            </div>
          </div>
          <label v-if="ifVisible('until')">` + bbn._("Until") + `</label>
          <div v-if="ifVisible('until')">
            <bbn-datepicker v-model="source.row.until"
                            :min="minUntil"
            ></bbn-datepicker>
          </div>
          <label v-if="ifVisible('occurrences')">` + bbn._('Number of times') + `</label>
          <div v-if="ifVisible('occurrences')">
            <bbn-numeric v-model="source.row.occurrences"
                        :min="0"
                        style="width: 6em"
                        :nullable="true"
            ></bbn-numeric>
          </div>
        </div>
      </div>
    </div>
  </div>
</bbn-form>
        `,
        props: ['source'],
        data(){
          return {
            staff: appui.app.staffActive,
            root: appui.plugins['appui-hr'] + '/',
            frequencies: [{
              text: bbn._('Daily'),
              value: 'daily'
            }, {
              text: bbn._('Weekly'),
              value: 'weekly'
            }, {
              text: bbn._('Monthly'),
              value: 'monthly'
            }, {
              text: bbn._('Yearly'),
              value: 'yearly'
            }],
            intervals: {
              daily: bbn._('day(s)'),
              weekly: bbn._('week(s)'),
              monthly: bbn._('month(s)'),
              yearly: bbn._('year(s)')
            },
            monthWeeks: [-3, -2, -1 , 1, 2, 3],
            showMonthDays: true
          }
        },
        computed: {
          minUntil(){
            return bbn.date(this.source.row.start).add(1, 'days').format('YYYY-MM-DD');
          }, 
        },
        methods: {
          askEdit(ev){
            if ( this.source.row.id && this.source.row.recurring ){
              ev.preventDefault();
              this.getPopup({
                label: bbn._('Attention'),
                content: '<div class="bbn-padding bbn-c">' + bbn._('What events do you want to edit?') + '</div>',
                buttons: [{
                  text: bbn._('Only this'),
                  action: () => {
                    this.source.row.edit = 'this';
                    this.getRef('form').submit(true);
                    this.getPopup().close();
                  }
                }, {
                  text: bbn._('All series'),
                  action: () => {
                    this.source.row.edit = 'all';
                    this.getRef('form').submit(true);
                    this.getPopup().close();
                  }
                }, {
                  text: bbn._('Future'),
                  action: () => {
                    this.source.row.edit = 'future';
                    this.getRef('form').submit(true);
                    this.getPopup().close();
                  }
                }],
                closable: false,
                width: 300
              });
            }
          },
          afterSubmit(d){
            if( d.success ){
              appui.success(bbn._('Saved'));
              this.closest('bbn-container').find('appui-hr-tab-planning').fullRefresh();
            }
            else {
              appui.error();
            }
          },
          getDayName(day){
            return bbn.date().weekday(day).format('ddd');
          },
          getMonthName(month){
            return bbn.date().month(month).format('MMM');
          },
          addRemove(t, v){
            let idx = this.source.row[t].indexOf(v);
            if ( idx > -1 ){
              this.source.row[t].splice(idx, 1);
            }
            else {
              this.source.row[t].push(v);
            }
          },
          ifVisible(field){
            let ret = [];
            switch ( this.source.row.type ){
              case 'daily':
                ret.push('interval', 'ym', 'until', 'occurrences');
                break;
              case 'weekly':
                ret.push('interval', 'wd', 'ym', 'until', 'occurrences');
                break;
              case 'monthly':
                ret.push('interval', 'ym', 'until', 'occurrences');
                if ( this.showMonthDays ){
                  ret.push('md');
                }
                else {
                  ret.push('wd', 'mw');
                }
                break;
              case 'yearly':
                ret.push('interval', 'md', 'ym', 'until', 'occurrences');
                break;
            }
            return ret.includes(field);
          },
          resetRepeat(){
            this.source.row.interval = null;
            this.source.row.occurrences = null;
            this.source.row.until = null;
            this.source.row.wd = [];
            this.source.row.mw = [];
            this.source.row.md = [];
            this.source.row.ym = [];
          }
        },
        watch: {
          'source.row.recurring'(newVal){
            this.resetRepeat();
            this.source.row.type = 'daily';
          }
        }
      }
    }
  };
})();