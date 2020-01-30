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
				if ( row.substitutes && row.substitutes.length ){
					let substitutes = row.substitutes.split(',');
					ret = [];
					bbn.fn.each(substitutes, (e, i) => {
						ret.push(bbn.fn.get_field(appui.app.staffActive, {value: e}, 'text'));
					});
					ret.sort();
					ret = ret.join('<br>');
				}
				return ret;
			},
      renderName(row){
        return `<a href="${this.root}page/card/${row.id_staff}">${bbn.fn.get_field(appui.app.staffActive, 'value', row.id_staff, 'text')}</a>`;
      },
      renderNote(row){
        return row.note ? `<i class="nf nf-mdi-comment_outline bbn-large" title="${row.note}"></i>` : '';
      },
      openCard(row){
        bbn.fn.link(this.root + 'page/card/' + row.id_staff);
      },
      buttons(row){
        return [[{
          text: bbn._("Look at the staff card"),
          icon: 'nf nf-fa-address_card_o',
          notext: true,
          action: this.openCard
        }]]
      }
    }
  };
})();