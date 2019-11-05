(() => {
  return {
    data(){
      return {
        tabs: bbn.fn.map(Object.values(this.source.tabs), (t, i) => {
          return bbn.fn.extend(true, {
            static: true,
            load: false,
            notext: true
          }, t)
        })
      }
    }
  }
})();