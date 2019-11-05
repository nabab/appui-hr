(() => {
  return {
    props: {
      source: {
        type: Object
      },
      selected: {
        type: [Boolean, String]
      }
    },
    computed: {
      isWorkingDay(){
        return !!this.source.events.filter((e) => {
          return e.holiday_id
        });
      }
    },
    methods: {
      getEmploye(id){
        return bbn.fn.get_field(appui.app.employees, 'value', id, 'text');
      }
    }
  }
})();