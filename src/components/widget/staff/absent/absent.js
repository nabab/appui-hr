(() => {
  return {
    props: ['source'],
    data(){
      let type = bbn.fn.get_row(appui.options.hr.absences, 'value', this.source.id_type);
      return {
        staff: bbn.fn.get_field(appui.app.staffActive, 'value', this.source.id, 'text'),
        linkCard: appui.plugins['appui-hr'] + '/page/card/' + this.source.id,
        type: type.text,
        color: type.color,
        start: bbn.fn.fdate(this.source.start),
        end: bbn.fn.fdate(this.source.end)
      }
    }
  }
})();