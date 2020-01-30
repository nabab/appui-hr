(() => {
  return {
    props: ['source'],
    data(){
      return {
        root: appui.plugins['appui-hr'] + '/'
      }
    },
    computed: {
      sameDay(){
        return this.startDay === this.endDay;
      },
      startDay(){
        return moment(this.source.start).format('DD/MM/YYYY');
      },
      endDay(){
        return moment(this.source.end).format('DD/MM/YYYY');
      },
      color(){
        return bbn.fn.get_field(appui.options.hr.absences, 'value', this.source.id_type, 'color');
      }
    },
    methods: {
      getStaff(id){
        return bbn.fn.get_field(appui.app.staffActive, {value: id}, 'text')
      },
      edit(){
        this.getPopup().open({
          title: bbn._('Edit'),
          height: 400,
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
      openCard(){
        bbn.fn.link(this.root + 'page/card/' + this.source.id_staff);
      }
    }
  };
})();