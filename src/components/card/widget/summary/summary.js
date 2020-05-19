(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    },
    methods: {
      getText(id){
        return bbn.fn.getField(appui.options.hr.absences, 'text', 'value', id);
      },
      getColor(id){
        return bbn.fn.getField(appui.options.hr.absences, 'color', 'value', id);
      }
    }
  };
})();