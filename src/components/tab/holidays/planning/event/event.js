(() => {
  return {
    props: ['source'],
    data(){
      return {}
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
      edit(){
        this.getPopup().open({
          title: bbn._('Modifier'),
          height: 400,
          width: 600,
          component: 'ami-hr-form-event',
          source: this.source
        });
      },
      remove(){
        this.confirm(bbn._('Êtes-vous sûr de bien vouloir supprimer cet élément?'), () => {
          this.post('actions/hr/holidays/delete', {id: this.source.id}, d => {
            if ( d.success ){
              appui.success(bbn._('Supprimé'));
              this.closest('ami-hr-tab-holidays-planning').fullRefresh();
            }
          })
        });
      },
      openCard(){
        bbn.fn.link('hr/card/' + this.source.id_employe);
      }
    }
  };
})();