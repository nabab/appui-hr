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
        root: appui.plugins['appui-hr'] + '/'
      }
    },
    methods: {
			renderSub(row){
				let ret = '';
				if ( row.employes && row.employes.length ){
					let employes = row.employes.split(',');
					ret = [];
					bbn.fn.each(employes, (e, i) => {
						ret.push(bbn.fn.get_field(appui.app.staff, {value: e}, 'text'));
					});
					ret.sort();
					ret = ret.join('<br>');
				}
				return ret;
			},
      renderName(row){
        return `<a href="${this.root}page/card/${row.id_employe}">${bbn.fn.get_field(appui.app.staff, 'value', row.id_employe, 'text')}</a>`;
      },
      renderNote(row){
        return row.note ? `<i class="nf nf-mdi-comment_outline bbn-large" title="${row.note}"></i>` : '';
      },
      openCard(row){
        bbn.fn.link(this.root + 'page/card/' + row.id_employe);
      },
      buttons(row){
        return [[{
          text: bbn._("Regarde la carte d'employé"),
          icon: 'fas fa-address-card',
          notext: true,
          command: this.openCard
        }]]
      }
    }
  };
})();