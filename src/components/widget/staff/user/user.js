(() => {
  return {
    computed: {
      fullname(){
        let name = bbn.fn.getField(appui.app.staffActive, 'text', 'value', this.source.id);
        return `<a href="${appui.plugins['appui-hr']}/page/card/${this.source.id}">${name}</a>`;
      },
      group(){
        return bbn.fn.getField(appui.app.groups, 'group', 'id', this.source.id_group);
      }
    }
  };
})();