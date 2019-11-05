(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      }
    }
  };
})();