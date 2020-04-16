+(function($) {
  console.log("sb");

  const w = "dsd";

  let obj = {
    a: 1,
    b: 2
  };

  const p = new Proxy(obj, {
    get(target, key, value) {
      if (key === "c") {
        return "我是自定义的一个结果";
      } else {
        return target[key];
      }
    },
    set(target, key, value) {
      if (value === 4) {
        target[key] = "我是自定义的一个结果";
      } else {
        target[key] = value;
      }
    }
  });
})(jQuery);
