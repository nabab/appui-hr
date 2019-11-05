(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    },
    methods: {
      renderNom(row){
        return row.nom && row.id_entity ? 
          '<a class="chantier" href="chantier/fiche/' + row.id_entity + '">' + bbn.fn.nl2br(row.nom) + '</a>' : 
          '';
      },
      renderAdresse(row){
        return row.fulladdress && row.id_entity ? 
          '<a class="chantier" href="chantier/fiche/' + row.id_entity + '">' + bbn.fn.nl2br(row.fulladdress) + '</a>' : 
          '';
      },
      renderHour(row){
        return parseFloat(row.hour);
      }
    }
  };
})();