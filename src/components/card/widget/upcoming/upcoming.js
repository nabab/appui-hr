(() => {
  return {
    data(){
      return {
        absences: appui.options.hr.absences
      }
    },
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    }
  }
})();