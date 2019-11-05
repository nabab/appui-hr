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
        employes: appui.app.employees,
        absences: appui.options.hr.absences
      }
    },
    methods: {
			renderEmployes(row){
				let ret = '';
				if ( row.employes && row.employes.length ){
					let employes = row.employes.split(',');
					ret = [];
					bbn.fn.each(employes, (e, i) => {
						ret.push(bbn.fn.get_field(appui.app.employees, {value: e}, 'text'));
					});
					ret.sort();
					ret = ret.join('<br>');
				}
				return ret;
			},
      renderEmploye(row){
        return `<a href="hr/card/${row.id_employe}">${bbn.fn.get_field(this.employes, 'value', row.id_employe, 'text')}</a>`;
      },
      renderNote(row){
        return row.note ? `<i class="nf nf-mdi-comment_outline bbn-large" title="${row.note}"></i>` : '';
      },
      openCard(row){
        bbn.fn.link('hr/card/' + row.id_employe);
      }
    }
  };
})();