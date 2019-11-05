(() => {
  return {
    data(){
      return {
        dashURL: appui.plugins && appui.plugins['appui-dashboard'] ? 
          appui.plugins['appui-dashboard'] + '/actions/' : ''
      }
    },
    computed: {
      hr(){
        return this.closest(`appui-hr-main`)
      }
    }
  };
})();