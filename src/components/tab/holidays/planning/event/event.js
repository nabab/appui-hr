(() => {
  return {
    props: ['source'],
    data(){
      return {
        root: appui.plugins['appui-hr'] + '/',
        hr: this.closest('appui-hr-main')
      }
    },
    computed: {
      sameDay(){
        return this.startDay === this.endDay;
      },
      startDay(){
        return dayjs(this.source.start).format('DD/MM/YYYY');
      },
      endDay(){
        return dayjs(this.source.end).format('DD/MM/YYYY');
      },
      color(){
        return bbn.fn.getField(appui.options.hr.absences, 'color', 'value', this.source.id_type);
      },
      status(){
        return this.source.status ? bbn.fn.getRow(this.hr.holidaysStatus, {value: this.source.status}) : false
      },
      showAccept(){
        return this.hr.source.perms.write &&
          (
            (this.source.status === 'cancelled') ||
            (this.source.status === 'refused') ||
            bbn.fn.isNull(this.source.status)
          )
      },
      showCancel(){
        return this.hr.source.perms.write &&
          (
            (this.source.status === 'accepted') ||
            bbn.fn.isNull(this.source.status)
          )
      },
      showRefuse(){
        return this.hr.source.perms.write &&
          (
            (this.source.status === 'accepted') ||
            bbn.fn.isNull(this.source.status)
          )
      }
    },
    methods: {
      getField: bbn.fn.getField,
      getStaff(id){
        return bbn.fn.getField(appui.app.staffActive, 'text', {value: id})
      },
      edit(){
        this.getPopup().open({
          title: bbn._('Edit'),
          height: 420,
          width: 600,
          component: 'appui-hr-form-event',
          source: this.source,
          scrollable: false
        });
      },
      remove(){
        this.confirm(bbn._('Are you sure you want to delete this item?'), () => {
          this.post(this.root + 'actions/holidays/delete', {id: this.source.id}, d => {
            if ( d.success ){
              appui.success(bbn._('Deleted'));
              this.closest('appui-hr-tab-holidays-planning').fullRefresh();
            }
          })
        });
      },
      accept(){
        if ( this.source.id_staff && this.source.id ){
          this.confirm(bbn._('Are you sure you want to accept it?'), () => {
            this.post(this.root + 'actions/holidays/accept', {
              id_staff: this.source.id_staff,
              id_event: this.source.id
            }, d => {
              if ( d.success ){
                appui.success(bbn._('Accepted'));
                this.closest('appui-hr-tab-holidays-planning').fullRefresh();
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      cancel(){
        if ( this.source.id_staff && this.source.id ){
          this.confirm(bbn._('Are you sure you want to cancel it?'), () => {
            this.post(this.root + 'actions/holidays/cancel', {
              id_staff: this.source.id_staff,
              id_event: this.source.id
            }, d => {
              if ( d.success ){
                appui.success(bbn._('Cancelled'));
                this.closest('appui-hr-tab-holidays-planning').fullRefresh();
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      refuse(){
        if ( this.source.id_staff && this.source.id ){
          this.confirm(bbn._('Are you sure you want to refuse it?'), () => {
            this.post(this.root + 'actions/holidays/refuse', {
              id_staff: this.source.id_staff,
              id_event: this.source.id
            }, d => {
              if ( d.success ){
                appui.success(bbn._('Refused'));
                this.closest('appui-hr-tab-holidays-planning').fullRefresh();
              }
              else {
                appui.error();
              }
            })
          })
        }
      },
      openCard(){
        bbn.fn.link(this.root + 'page/card/' + this.source.id_staff);
      }
    }
  };
})();