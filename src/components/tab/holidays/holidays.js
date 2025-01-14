(() => {
  let count = 0;
  return {
    data(){
      return {
        groups: bbn.fn.order(appui.groups.map(g => {
          return {
            text: g.group,
            value: g.id,
            num: g.num
          }
        }), 'text', 'ASC'),
        absences: appui.options.hr.absences,
        root: appui.plugins['appui-hr'] + '/',
        hr: this.closest('appui-hr-main'),
        staff: appui.app.staffActive
      }
    },
    methods: {
      renderStatus(row){
        let s = bbn.fn.getRow(this.hr.holidaysStatus, {value: row.status});
        return s ? `<span class="bbn-${s.color}">${s.text}</span>` : '-';
      },
			renderSub(row){
				let ret = '';
				if ( row.substitutes && row.substitutes.length ){
					let substitutes = row.substitutes.split(',');
					ret = [];
					bbn.fn.each(substitutes, (e, i) => {
						ret.push(bbn.fn.getField(appui.app.staffActive, 'text', {value: e}));
					});
					ret.sort();
					ret = ret.join('<br>');
				}
				return ret;
			},
      renderName(row){
        return `<a href="${this.root}page/card/${row.id_staff}">${bbn.fn.getField(appui.app.staffActive, 'text', 'value', row.id_staff)}</a>`;
      },
      renderNote(row){
        return row.note ? `<i class="nf nf-mdi-comment_outline bbn-large" title="${row.note}"></i>` : '';
      },
      openCard(row){
        bbn.fn.link(this.root + 'page/card/' + row.id_staff);
      },
      remove(row){
        if ( row.id_event ){
          this.confirm(bbn._('Are you sure you want to delete it?'), () => {
            this.post(this.root + 'actions/holidays/delete', {id: row.id_event}, d => {
              if ( d.success ){
                this.getRef('table').updateData();
                appui.success(bbn._('Deleted'));
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      accept(row){
        if ( row.id_staff && row.id_event ){
          this.confirm(bbn._('Are you sure you want to accept it?'), () => {
            this.post(this.root + 'actions/holidays/accept', {
              id_staff: row.id_staff,
              id_event: row.id_event
            }, d => {
              if ( d.success ){
                this.getRef('table').updateData();
                appui.success(bbn._('Accepted'));
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      cancel(row){
        if ( row.id_staff && row.id_event ){
          this.confirm(bbn._('Are you sure you want to cancel it?'), () => {
            this.post(this.root + 'actions/holidays/cancel', {
              id_staff: row.id_staff,
              id_event: row.id_event
            }, d => {
              if ( d.success ){
                this.getRef('table').updateData();
                appui.success(bbn._('Cancelled'));
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      refuse(row){
        if ( row.id_staff && row.id_event ){
          this.confirm(bbn._('Are you sure you want to refuse it?'), () => {
            this.post(this.root + 'actions/holidays/refuse', {
              id_staff: row.id_staff,
              id_event: row.id_event
            }, d => {
              if ( d.success ){
                this.getRef('table').updateData();
                appui.success(bbn._('Refused'));
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      buttons(row){
        let bts = [],
            objC = bbn.fn.getRow(this.hr.holidaysStatus, {value: 'cancelled'}),
            objA = bbn.fn.getRow(this.hr.holidaysStatus, {value: 'accepted'}),
            objR = bbn.fn.getRow(this.hr.holidaysStatus, {value: 'refused'}),
            cancel = {
              text: bbn._("Cancel"),
              icon: objC.onlyIcon,
              notext: true,
              action: this.cancel,
              class: 'bbn-bg-' + objC.color
            },
            accept = {
              text: bbn._("Accept"),
              icon: objA.onlyIcon,
              notext: true,
              action: this.accept,
              class: 'bbn-bg-' + objA.color
            },
            refuse = {
              text: bbn._("Refuse"),
              icon: objR.onlyIcon,
              notext: true,
              action: this.refuse,
              class: 'bbn-bg-' + objR.color
            };
        if ( this.hr.source.perms.write ){
          switch ( row.status ){
            case 'accepted':
              bts.push(cancel, refuse);
              break;
            case 'refused':
              bts.push(accept)
              break;
            case 'cancelled':
              bts.push(accept, refuse);
              break;
            default:
              bts.push(accept, cancel, refuse);
              break;
          }
        }
        bts.push({
          text: bbn._("Look at the staff card"),
          icon: 'nf nf-fa-address_card_o',
          notext: true,
          action: this.openCard
        });
        if ( this.hr.source.perms.write ){
          bts.push({
            text: bbn._("Delete"),
            icon: 'nf nf-fa-trash',
            notext: true,
            action: this.remove
          });
        }
        return bts
      },
      colorRow(row,){
        let currentDate = dayjs(),
            past = dayjs(row.end).isBefore(currentDate),
            ongoing = dayjs(row.start).isBefore(currentDate) && dayjs(row.end).isAfter(currentDate),
            future = dayjs(row.start).isAfter(currentDate);
        count++;
        if ( future ){
          return 'appui-hr-tab-holidays-future' + (count % 2 === 0 ? ' bbn-alt-light' : '');
        }
        else if ( past ){
          return 'appui-hr-tab-holidays-past' + (count % 2 === 0 ? ' bbn-alt-light' : '');
        }
      }
    },
    component: {
      toolbar: {
        template: `
<div class="bbn-header bbn-spadding">
  <div class="bbn-flex-width">
    <div class="bbn-flex-fill">
      <bbn-button label="` + bbn._('Excel') + `"
                  icon="nf nf-fa-file_excel_o"
                  @click="excel"
                  class="bbn-right-space"
      ></bbn-button>
      <span>` + bbn._('Month') + `:</span>
      <bbn-datepicker type="months"
                      :nullable="true"
                      v-model="currentMonth"
                      class="bbn-right-space"
                      :disabled="!!currentPeriod"
      ></bbn-datepicker>
      <span>` + bbn._('Period') + `:</span>
      <bbn-dropdown :source="period"
                    v-model="currentPeriod"
                    :nullable="true"
                    class="bbn-right-space"
                    style="width: 8em"
                    :disabled="!!currentMonth"
      ></bbn-dropdown>
      <span>` + bbn._('Status') + `:</span>
      <bbn-dropdown :source="hr.holidaysStatus"
                    v-model="currentStatus"
                    :nullable="true"
      ></bbn-dropdown>
    </div>
    <div>
      <div class="bbn-middle appui-hr-tab-holidays-legend bbn-h-100">
        <div v-for="p in period">
          <div class="bbn-vmiddle bbn-hsmargin">
            <div class="bbn-hsmargin bbn-border appui-hr-tab-holidays-legend-item"
                 :style="{backgroundColor: p.color}"
            ></div>
            <span v-text="p.text"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        `,
        data(){
          return {
            hr: this.closest('appui-hr-main'),
            currentStatus: null,
            currentMonth: null,
            table: this.closest('bbn-table'),
            period: [{
              text: bbn._('Past'),
              value: 'past',
              icon: 'nf nf-fa-square appui-hr-tab-holidays-past',
              color: 'lightpink'
            }, {
              text: bbn._('Ongoing'),
              value: 'ongoing',
              icon: 'nf nf-fa-square_o',
              color: ''
            }, {
              text: bbn._('Future'),
              value: 'future',
              icon: 'nf nf-fa-square appui-hr-tab-holidays-future',
              color: 'lightcyan'
            }],
            currentPeriod: null
          }
        },
        methods: {
          excel(){
            this.table.exportExcel();
          }
        },
        watch: {
          currentStatus(newVal, oldVal){
            if ( newVal !== oldVal ){
              let f = bbn.fn.search(this.table.currentFilters.conditions, {field: 'status'});
              if ( newVal ){
                if ( f > -1 ){
                  this.table.currentFilters.conditions[f].operator = '=';
                  this.table.currentFilters.conditions[f].value = newVal;
                }
                else {
                  this.table.currentFilters.conditions.push({
                    field: 'status',
                    operator: '=',
                    value: newVal
                  });
                }
              }
              else if ( f > -1 ){
                this.table.currentFilters.conditions.splice(f, 1);
              }
            }
          },
          currentMonth(newVal, oldVal){
            if ( newVal !== oldVal ){
              if ( newVal ){
                let m = dayjs(newVal, 'YYYY-MM');
                this.table.currentFilters.conditions.splice(0, this.table.currentFilters.conditions.length, {
                  logic: 'OR',
                  conditions: [{
                    conditions: [{
                      field: 'start',
                      operator: '<=',
                      value: newVal + '-01'
                    }, {
                      field: 'end',
                      operator: '>=',
                      value: newVal + '-' + m.daysInMonth()
                    }]
                  }, {
                    conditions: [{
                      field: 'start',
                      operator: '>=',
                      value: newVal + '-01'
                    }, {
                      field: 'start',
                      operator: '<=',
                      value: newVal + '-' + m.daysInMonth()
                    }]
                  }]
                });
              }
              else {
                this.table.currentFilters.conditions.splice(0);
              }
              this.currentStatus = null;
            }
          },
          currentPeriod(newVal, oldVal){
            if ( newVal !== oldVal ){
              if ( newVal ){
                let cond = {},
                    currentDate = dayjs().format('YYYY-MM-DD');
                switch ( newVal ){
                  case 'past':
                    cond = {
                      field: 'end',
                      operator: '<',
                      value: currentDate
                    };
                    break;
                  case 'ongoing':
                    cond.conditions = [{
                      field: 'start',
                      operator: '<',
                      value: currentDate
                    }, {
                      field: 'end',
                      operator: '>',
                      value: currentDate
                    }];
                    break;
                  case 'future':
                    cond = {
                      field: 'start',
                      operator: '>',
                      value: currentDate
                    };
                    break;
                }
                this.table.currentFilters.conditions.splice(0, this.table.currentFilters.conditions.length, cond);
              }
              else {
                this.table.currentFilters.conditions.splice(0);
              }
              this.currentStatus = null;
            }
          }
        }
      }
    }
  };
})();