(() => {
  return {
    data(){
      let type = bbn.fn.get_row(appui.options.hr.absences, 'value', this.source.id_type);
      return {
        linkFiche: "chantier/fiche/" + this.source.id_entity + "/infos",
        fulladdress: bbn.fn.nl2br(this.source.chantier_adresse),
        employee: bbn.fn.get_field(appui.app.employees, 'value', this.source.id_employe, 'text'),
        type: type.text,
        color: type.color,
        start: bbn.fn.fdate(this.source.start),
        end: bbn.fn.fdate(this.source.end)
      }
    }
  }
})();