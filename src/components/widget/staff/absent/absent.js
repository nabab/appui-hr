(() => {
  return {
    props: ['source'],
    data(){
      let type = bbn.fn.getRow(appui.options.hr.absences, 'value', this.source.id_type);
      return {
        staff: bbn.fn.getField(appui.app.staffActive, 'text', 'value', this.source.id),
        linkCard: appui.plugins['appui-hr'] + '/page/card/' + this.source.id,
        type: type.text,
        color: type.color,
        start: bbn.fn.fdate(this.source.start),
        end: bbn.fn.fdate(this.source.end)
      }
    }
  }
})();