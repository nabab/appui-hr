(() => {
  return {
    props: ['source'],
    data(){
      return {
        tab: this.closest('bbn-container').getComponent()
      }
    },
    methods: {
      afterSubmit(d){
        if ( d.success ){
          if ( !this.source.row.id && d.data && d.data.id_employe ){
            appui.app.staff.push({
              text: this.source.row.surname + ' ' + this.source.row.name,
              value: d.data.id_employe,
              id_user: d.data.id_user
            });
            appui.app.staffActive.push({
              text: this.source.row.surname + ' ' + this.source.row.name,
              value: d.data.id_employe,
              id_user: d.data.id_user
            });
          }
          else if ( this.source.row.id && d.data ){
            let idx = bbn.fn.search(appui.app.staff, 'value', this.source.row.id),
                idxActive = bbn.fn.search(appui.app.staffActive, 'value', this.source.row.id);
            if ( idx > -1 ){
              appui.$set(appui.app.staff[idx], 'text', this.source.row.surname + ' ' + this.source.row.name);
              appui.$set(appui.app.staff[idx], 'id_user', d.data.id_user);
            }
            if ( idxActive > -1 ){
              appui.$set(appui.app.staffActive[idxActive], 'text', this.source.row.surname + ' ' + this.source.row.name);
              appui.$set(appui.app.staffActive[idxActive], 'id_user', d.data.id_user);
            }
          }
          appui.app.staff = bbn.fn.order(appui.app.staff, 'text', 'ASC');
          appui.app.staffActive = bbn.fn.order(appui.app.staffActive, 'text', 'ASC');
          appui.success(bbn._('Saved'));
          if ( this.tab.getRef('table') ){
            this.tab.getRef('table').updateData();
          }
        }
        else {
          appui.error(bbn._('Error'));
        }
      }
    }
  }
})();