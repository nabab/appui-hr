(() => {
  return {
    computed: {
      card(){
        return this.closest(`appui-hr-card`)
      },
      entities(){
        return this.source.entities.map(e => {
          if ( e.cfg.length ){
            bbn.fn.extend(e, JSON.parse(e.cfg), {adresse: bbn.fn.nl2br(e.fulladdress)});
          }
          return e;
        })
      },
      htotal(){
        let tot = 0;
        bbn.fn.each(this.source.entities, e => {
          bbn.fn.iterate(e, (o, k) => {
            if (
              ((k === 'monday') ||
              (k === 'tuesday') ||
              (k === 'thursday') ||
              (k === 'wednesday') ||
              (k === 'friday') ||
              (k === 'saturday') ||
              (k === 'sunday')) &&
              bbn.fn.isNumber(o)
            ){
              tot += o;
            }
          });  
        });
        return tot;
      }
    },
    methods: {
      hsem(obj){
        let tot = 0;
        bbn.fn.iterate(obj, (o, k) => {
          if (
            ((k === 'monday') ||
            (k === 'tuesday') ||
            (k === 'thursday') ||
            (k === 'wednesday') ||
            (k === 'friday') ||
            (k === 'saturday') ||
            (k === 'sunday')) &&
            bbn.fn.isNumber(o)
          ){
            tot += o;
          }
        });
        return tot;
      }
    }
  }
})();