jQuery,jQuery(document).ready(function(t){function e(e){var i=e.find(".network-url").map(function(){return t(this).prev(".network-choice").val()+"|"+t(this).val()}).toArray();e.find(".customize-control-sortable-repeater").val(i),e.find(".customize-control-sortable-repeater").trigger("change")}t("#add_link").on("click",function(){var e=t(".empty-link").clone(!0);return e.removeClass("empty-link"),e.addClass("ui-state-default"),e.insertBefore("#blueprint-social-list li:last-child"),!1}),t("#sort_links").on("click",function(){t("#blueprint-social-list").addClass("enable-sort").sortable({opacity:.6,revert:!0,cursor:"move",handle:".sort_handle",placeholder:"ui-state-highlight",start:function(e,i){t(i.item).css({opacity:"1",width:"80%","max-width":"100%",height:"auto"}),t(i.item).addClass("onthemove")},stop:function(e,i){t(i.item).removeClass("onthemove").addClass("changed")},update:function(i,n){e(t(this).parent())}}),t(this).attr("disabled","disabled"),t("#save_sort").fadeIn()}),t("#save_sort").on("click",function(){t(this).fadeOut(),e(t("#blueprint-social-list").parent()),t("#sort_links").removeAttr("disabled","disabled")}),t(".remove_link").on("click",function(){return t(this).parent("li").remove(),!1}),t(".repeater select").change(function(){var i=this.value;t(this).next(".network-choice").val(i),e(t("#blueprint-social-list").parent())}),t(".network-url").change(function(){e(t("#blueprint-social-list").parent())}),t(".network-url").on("input",function(){e(t("#blueprint-social-list").parent())})});