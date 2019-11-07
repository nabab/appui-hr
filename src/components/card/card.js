(() => {
  return {
    data(){
      let idUser = bbn.fn.get_field(appui.app.staff, 'value', this.source.id, 'id_user');
      return {
        idUser: idUser,
        idGroup: idUser ? bbn.fn.get_field(appui.app.users, 'value', idUser, 'id_group') : false,
        absences: appui.options.hr.absences,
        root: appui.plugins['appui-hr'] + '/'
      }
    }
  };
})();