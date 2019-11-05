(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    },
    methods: {
      getText(id){
        return bbn.fn.get_field(appui.options.hr.absences, 'value', id, 'text');
      },
      getColor(id){
        return bbn.fn.get_field(appui.options.hr.absences, 'value', id, 'color');
      }
    }
  };
})();