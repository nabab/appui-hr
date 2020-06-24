(() => {
  return {
    data(){
      return {
        groups: bbn.fn.order(appui.app.groups.map(g => {
          return {
            text: g.group,
            value: g.id,
            num: g.num
          }
        }), 'text', 'ASC'),
        absences: appui.options.hr.absences,
        root: appui.plugins['appui-hr'] + '/',
        hr: this.closest('appui-hr-main')
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
        bts.push({
          text: bbn._("Delete"),
          icon: 'nf nf-fa-trash',
          notext: true,
          action: this.remove
        })
        return bts
      }
    },
    component: {
      toolbar: {
        template: `
<div class="bbn-header bbn-spadded">
  <div class="bbn-flex-width">
    <bbn-button text="` + bbn._('Excel') + `"
                icon="nf nf-fa-file_excel_o"
                @click="excel"
    ></bbn-button>
    <div class="bbn-flex-fill bbn-r">
      <span>` + bbn._('Status') + `:</span>
      <bbn-dropdown :source="hr.holidaysStatus"
                    v-model="currentStatus"
                    :nullable="true"
      ></bbn-dropdown>
    </div>
  </div>
</div>
        `,
        data(){
          return {
            hr: this.closest('appui-hr-main'),
            currentStatus: null
          }
        },
        methods: {
          excel(){
            this.closest('bbn-table').exportExcel();
          }
        },
        watch: {
          currentStatus(newVal, oldVal){
            if ( newVal !== oldVal ){
              let tab = this.closest('bbn-table'),
                  f = bbn.fn.search(tab.currentFilters.conditions, {field: 'status'});
              if ( newVal ){
                if ( f > -1 ){
                  tab.currentFilters.conditions[f].operator = '=';
                  tab.currentFilters.conditions[f].value = newVal;
                }
                else {
                  tab.currentFilters.conditions.push({
                    field: 'status',
                    operator: '=',
                    value: newVal
                  });
                }
              }
              else if ( f > -1 ){
                tab.currentFilters.conditions.splice(f, 1);
              }
            }
          }
        }
      }
    }
  };
})();