(function () {
    if (typeof window.Element === "undefined" ||
            "classList" in document.documentElement) {
        return;
    }

    var prototype = Array.prototype,
            push = prototype.push,
            splice = prototype.splice,
            join = prototype.join;

    function DOMTokenList(el) {
        this.el = el;
        // The className needs to be trimmed and split on whitespace
        // to retrieve a list of classes.
        var classes = el.className.replace(/^\s+|\s+$/g, '').split(/\s+/);
        for (var i = 0; i < classes.length; i++) {
            push.call(this, classes[i]);
        }
    }

    DOMTokenList.prototype = {
        add: function (token) {
            if (this.contains(token))
                return;
            push.call(this, token);
            this.el.className = this.toString();
        },
        contains: function (token) {
            return this.el.className.indexOf(token) != -1;
        },
        item: function (index) {
            return this[index] || null;
        },
        remove: function (token) {
            if (!this.contains(token))
                return;
            for (var i = 0; i < this.length; i++) {
                if (this[i] == token)
                    break;
            }
            splice.call(this, i, 1);
            this.el.className = this.toString();
        },
        toString: function () {
            return join.call(this, ' ');
        },
        toggle: function (token) {
            if (!this.contains(token)) {
                this.add(token);
            } else {
                this.remove(token);
            }

            return this.contains(token);
        }
    };

    window.DOMTokenList = DOMTokenList;

    function defineElementGetter(obj, prop, getter) {
        if (Object.defineProperty) {
            Object.defineProperty(obj, prop, {
                get: getter
            });
        } else {
            obj.__defineGetter__(prop, getter);
        }
    }

    defineElementGetter(HTMLElement.prototype, 'classList', function () {
        return new DOMTokenList(this);
    });
})();

function showLoadingIcon(bShow) {
    if (bShow) {
        console.log("show loading!!!!");
        document.getElementById("loading").style.display = "block";
    } else {
        console.log("hide loading!!!!");
        document.getElementById("loading").style.display = "none";
    }
}
document.addEventListener("deviceready", function () {
    document.addEventListener("backbutton", function () {
        console.log("exit app;");
        showLoadingIcon(true);
        location.href = "../../hotel_01/";
    });
}, false);

