(() => {
  return {
    props: ['source'],
    data(){
      let type = bbn.fn.get_row(appui.options.hr.absences, 'value', this.source.id_type);
      return {
        employee: bbn.fn.get_field(appui.app.employees, 'value', this.source.id, 'text'),
        type: type.text,
        color: type.color,
        start: bbn.fn.fdate(this.source.start),
        end: bbn.fn.fdate(this.source.end)
      }
    }
  }
})();