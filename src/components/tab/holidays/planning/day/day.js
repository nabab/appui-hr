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
    methods: {
      getEmploye(id){
        return bbn.fn.get_field(appui.app.employees, {value: id}, 'text')
      }
    },
    components: {
      item: {
        props: {
          source: {
            type: Object
          }
        },
        template: `
<div class="bbn-hspadded bbn-vmiddle">
  <div class="bbn-flex-width" style="margin-bottom: .1rem">
    <bbn-initial :user-name="getEmploye(source.employe)"
                 :width="20"
    ></bbn-initial>
    <div class="bbn-flex-fill bbn-hsmargin"
         v-text="absence"
    ></div>
  </div>
</div>`,
        computed: {
          color(){
            return bbn.fn.get_field(appui.options.hr.absences, 'value', this.source.id_type, 'color');
          },
          absence(){
            return bbn.fn.get_field(appui.options.hr.absences, 'value', this.source.id_type, 'text');
          },
          employe(){
            return bbn.fn.get_field(appui.app.employees, {value: this.source.employe}, 'text')
          }
        }
      }
    }
  }
})();