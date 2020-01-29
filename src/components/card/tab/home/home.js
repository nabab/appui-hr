(() => {
  return {
    data(){
      return {
        currentYear: moment().format('YYYY')
      }
    },
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    },
    methods: {
      infoBtns(){
        if ( 
          appui.app.user.isAdmin ||
          appui.app.user.isDev ||
          (appui.app.group.group.toLowerCase() === 'managers')
        ){
          return [{
            icon: 'nf nf-fa-edit',
            text: bbn._('Edit'),
            notext: true,
            action: this.editInfo
          }]
        }
        return [];
      },
      editInfo(){
        this.getPopup().open({
          title: bbn._("Edit"),          
          width: 600,
          component: 'ami-hr-form-staff',
          source: {
            row: this.source.info
          }
        });
      }
    }
  }
})();