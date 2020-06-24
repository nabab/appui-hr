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
        }),
        holidaysStatus: [{
          text: bbn._('Accepted'),
          value: 'accepted',
          color: 'green',
          icon: 'nf nf-fa-thumbs_up bbn-green',
          onlyIcon: 'nf nf-fa-thumbs_up'
        }, {
          text: bbn._('Cancelled'),
          value: 'cancelled',
          color: 'orange',
          icon: 'nf nf-fa-thumbs_down bbn-orange',
          onlyIcon: 'nf nf-fa-thumbs_down'
        }, {
          text: bbn._('Refused'),
          value: 'refused',
          color: 'red',
          icon: 'nf nf-fa-thumbs_down bbn-red',
          onlyIcon: 'nf nf-fa-thumbs_down'
        }]
      }
    }
  }
})();