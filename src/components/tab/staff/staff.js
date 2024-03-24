(() => {
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
        employes: appui.app.staffActive,
        root: appui.plugins['appui-hr'] + '/',
        hr: this.closest('appui-hr-main')
      }
    },
    computed: {
      toolbar(){
        let btns = [];
        if ( !!this.hr.source.perms.write ){
          btns.push({
            text: bbn._('Add'),
            action: this.insert,
            icon: 'nf nf-fa-plus'
          });
        }
        btns.push({
          text: bbn._('Excel'),
          icon: 'nf nf-fa-file_excel_o',
          action: 'excel'
        });
        return btns;
      }
    },
    methods:{
      renderName(row){
        return `${row.surname} ${row.name}`;
      },
      insert(){
        this.getRef('table').insert({}, {
          title: bbn._("New employe"),
          width: 600
        });
      },
      edit(row, col, idx){
        this.getRef('table').edit(row, {
          title: bbn._("Edit employe"),
          width: 600
        }, idx);
      },
      remove(row, col, idx){
        if ( row.id ){
          this.confirm(bbn._('Are you sure you want to delete this employe?'), () => {
            this.post(this.root + 'actions/employees/delete', {id: row.id }, d => {
              if ( d.success ){
                let idx = bbn.fn.search(appui.app.staffActive, 'value', row.id);
                if ( idx > -1 ){
                  appui.app.staffActive.splice(idx, 1);
                }
                appui.success(bbn._('Deleted'));
                this.getRef('table').updateData();
              }
              else {
                appui.error(bbn._('Error'));
              }
            });
          });
        }
      },
      initilaze(row, col, idx){
        if( row.id_user ){
          this.confirm( bbn._("Are you sure you want to reset the password of this user?"), () => {
            this.post(appui.plugins['appui-usergroup'] + "/actions/users/init", {id: row.id_user}, d => {
             if ( d.success ){
               this.alert(bbn._("An email has been sent to") + ' ' + row.email, bbn._("Success"));
             }
             else{
               this.alert(bbn._("A problem has occurred"));
             }
           });
         });
        }
      },
      buttons(row){
        let btns = [{
          text: bbn._('See card'),
          action: this.open,
          icon: 'nf nf-fa-address_card',
          notext: true
        }];
        if ( !!this.hr.main.perms.write ){
          btns.push({
            text: bbn._('Edit'),
            action: this.edit,
            icon: 'nf nf-fa-edit',
            notext: true
          }, {
            text: bbn._('Deactivate'),
            action: this.remove,
            icon: 'nf nf-fa-times',
            notext: true
          });
          if ( row.id_user ){
            btns.push({
              text: bbn._('Initialize password'),
              action: this.initilaze,
              icon: 'nf nf-fa-envelope',
              notext: true
            });
          }
        }
        return btns;
      },
      open(row){
        bbn.fn.link(this.root + 'page/card/' + row.id);
      }
    }
  }
})();
