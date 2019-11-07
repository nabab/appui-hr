(() => {
  return {
    data(){
      let type = bbn.fn.get_row(appui.options.hr.absences, 'value', this.source.id_type);
      return {
        employee: bbn.fn.get_field(appui.app.staff, 'value', this.source.id_employe, 'text'),
        type: type.text,
        color: type.color,
        start: bbn.fn.fdate(this.source.start),
        end: bbn.fn.fdate(this.source.end),
        root: appui.plugins['appui-hr'] + '/'
      }
    }
  }
})();