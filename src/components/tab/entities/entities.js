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
        employes: appui.app.employees
      }
    },
    methods: {
      renderEmployee(row){
        return `<a href="hr/card/${row.id_employe}">${bbn.fn.get_field(this.employes, 'value', row.id_employe, 'text')}</a>`;
      },
      renderAdresse(row){
        if ( row.id_entity ){
          let type = bbn.fn.get_field(appui.options.entities, 'value', row.type_entity, 'code');
          return `<a class="${type}" href="${type}/fiche/${row.id_entity}">${bbn.fn.nl2br(row.chantier_adresse)}</a>`;
        }
        return '';
      },
      renderChantier(row){
        if ( row.id_entity ){
          let type = bbn.fn.get_field(appui.options.entities, 'value', row.type_entity, 'code');
          return `<a class="${type}" href="${type}/fiche/${row.id_entity}">${row.chantier}</a>`;
        }
        return '';
      },
      replaceEmployee(row){
        this.getPopup().open({
          title: bbn._('Remplacer employé'),
          height: 150,
          width: 500,
          component: 'ami-hr-form-employee-replace',
          source: {
            id_entity: row.id_entity,
            id_employe: '',
            id_old_employe: row.id_employe,
            start: row.start,
            end: row.end
          }
        });
      },
      replaceEmployeePlanning(row){
        this.getPopup().open({
          title: bbn._('Remplacer responsable'),
          height: '90%',
          width: '90%',
          component: 'ami-hr-form-employee-planning',
          source: {
            id_entity: row.id_entity,
            id_employe: row.id_employe
          }
        });
      }
    }
  };
})();