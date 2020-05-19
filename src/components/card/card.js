(() => {
  return {
    data(){
      let idUser = bbn.fn.getField(appui.app.staff, 'id_user', 'value', this.source.id);
      return {
        idUser: idUser,
        idGroup: idUser ? bbn.fn.getField(appui.app.users, 'id_group', 'value', idUser) : false,
        absences: appui.options.hr.absences,
        root: appui.plugins['appui-hr'] + '/'
      }
    },
    methods: {
      isObject: bbn.fn.isObject
    }
  };
})();