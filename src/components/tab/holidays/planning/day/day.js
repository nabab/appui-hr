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
      getStaff(id){
        return bbn.fn.getField(appui.app.staffActive, 'text', {value: id})
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
    <bbn-initial :user-name="getStaff(source.id_staff)"
                 :width="20"
    ></bbn-initial>
    <div class="bbn-flex-fill bbn-hsmargin"
         v-text="absence"
    ></div>
  </div>
</div>`,
        computed: {
          color(){
            return bbn.fn.getField(appui.options.hr.absences, 'color', 'value', this.source.id_type);
          },
          absence(){
            return bbn.fn.getField(appui.options.hr.absences, 'text', 'value', this.source.id_type);
          },
          staff(){
            return bbn.fn.getField(appui.app.staffActive, 'text', {value: this.source.staff})
          }
        },
        methods: {
          getStaff(id){
            return bbn.fn.getField(appui.app.staffActive, 'text', {value: id})
          }
        }
      }
    }
  }
})();