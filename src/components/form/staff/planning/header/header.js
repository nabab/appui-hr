(() => {
  return {
    data(){
      return {
        calendar: false,
        planning: false
      }
    },
    methods: {
      changeMode(){
        this.planning.changeMode(this.calendar);
      }
    },
    mounted(){
      this.calendar = this.closest('bbn-calendar');
      this.planning = this.closest('ami-hr-tab-planning');
    }
  }
})();