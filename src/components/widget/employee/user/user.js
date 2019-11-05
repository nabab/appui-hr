(() => {
  return {
    computed: {
      fullname(){
        let name = bbn.fn.get_field(appui.app.employees, 'value', this.source.id, 'text');
        return `<a href="${appui.plugins['appui-hr']}/page/card/${this.source.id}">${name}</a>`;
      },
      group(){
        return bbn.fn.get_field(appui.app.groups, 'id', this.source.id_group, 'group');
      }
    }
  };
})();