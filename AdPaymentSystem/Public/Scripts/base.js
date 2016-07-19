String.prototype.format = function () { var args = arguments; return this.replace(/\{(\d+)\}/g, function (m, i) { return args[i]; }); };

/*隔行换色*/
//function ghhs() {
//    var trList = $(".tab-list tr");
//    var cssClass = "";
//    trList.each(function (index) {
//        if (index === 0) {
//            return;
//        }
//        if (index % 2 === 0) {
//            cssClass = "odd";
//        } else {
//            cssClass = "even";
//        }

//        $(this).addClass(cssClass);
//    });
//}
//$(function () {
//    ghhs();
//})
/*end 隔行换色*/

//鼠标停留列表内容时的效果
//需要条件：样式名为list,listHoverBGColor,具有tr
function load_mouseListEffect() {
    var listObj = $('.list tr');
    listObj.mouseover(function () {
        $('.listHoverBGColor').each(function () {
            $(this).removeClass('listHoverBGColor');
        });
        $(this).addClass('listHoverBGColor');
    });

    $('body').mouseout(function () {
        $('.listHoverBGColor').each(function () {
            $(this).removeClass('listHoverBGColor');
        });
    });
}
$(function () {
    load_mouseListEffect();
});

/*省市联动*/
var PCHelper = function (pName, cName, pID, cID) {
    this.pID = pID;
    this.cID = cID;
    this.pName = pName;
    this.cName = cName;

    var _t = this;
    $('#' + this.pName).change(function () {
    	 //console.log(pID);
        _t.ChangeProv($(this).find('option:selected').val());
    });
}

PCHelper.prototype.LoadPC = function () {
    if (this.pID != '') {
        this.ChangeProv(this.pID, this.cID);
    }
}

PCHelper.prototype.ChangeProv = function (pID, cID) {
    var _t = this;
    $.get('/index.php/Common/CityList', { action: 'get', provinceID: pID, selID: cID },
        function (data, status) {
            $('#' + _t.cName).html('<option value="0">所有城市</option>'+data);
        });
}
/*end 省市联动*/

function waitSearch(name) {
    $('#' + name).attr('disabled', true);
    $('#' + name).val('加载中...');
}


///*删除数据操作*/
//function DeleteData(url, type, id) {
//    if (!this.confirm('您确定要删除这一项吗？')) { return };
//
//    $.ajax({
//        url: url,
//        data: { type: type, id: id },
//        dataType: 'jsonp', jsonpCallback: 'ActionCallBack',
//        success: function (data) {
//            if (data == 'ok') {
//                window.location.reload();
//            } else {
//                alert(data);
//            }
//        }
//    });
//}

/**
 * 货币类型数字验证，输入的内容只能为数字加一个小数
 * @param obj
 */
function DigitalVerification(obj) { // 值允许输入一个小数点和数字 
    obj.value = obj.value.replace(/[^\d.]/g, ""); //先把非数字的都替换掉，除了数字和. 
    obj.value = obj.value.replace(/^\./g, ""); //必须保证第一个为数字而不是. 
    obj.value = obj.value.replace(/\.{2,}/g, "."); //保证只有出现一个.而没有多个. 
    obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", "."); //保证.只出现一次，而不能出现两次以上 
}

/*全选*/
function CheckAll(t) {
    $('input[name=IsSel]').prop('checked', $(t).prop('checked'));
}

/*删除单条记录*/
function DeleteSingleData(id, url) {
    if (!confirm('确定要删除数据吗？\n删除后不可恢复！')) {
        return false;
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: { 'id': id },
        dataType: "text",
        success: function (data) {
            //alert(data);
            console.log(data);
            location.reload();
        },
        error: function (data) {
            alert('删除出现了问题');
            location.reload();
        }
    });
}

/*删除多条记录*/
function DeleteMoreData(checkbox, url) {
    if (!confirm('确定要删除数据吗？\n删除后不可恢复！')) {
        return false;
    }

    var isSel = [];
    var i = 0;
    $('input[name=' + checkbox + ']').each(function () {
        if (this.checked) {
            isSel[i] = $(this).val();
            i++;
        }
    });
    if (isSel.length == 0) {
        alert('请选择需要删除的数据');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: { 'isSel': isSel },
        dataType: "text",
        success: function (data) {
            //alert(data);
            console.log(data);
            location.reload();
        },
        error: function (data) {
            alert('删除出现了问题');
            location.reload();
        }
    });
}

/*修改排序信息*/
function EditTaxis(dataId, url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: { "dataId": dataId, 'taxis': $('#taxis' + dataId).val() },
        dataType: "text",
        success: function (data) {
            console.log(data);
            location.reload();
        },
        error: function (data) {
            //console.log(data);
            alert('修改出现了问题，请联系管理员');
            location.reload();
        }
    });
}

/*设置属性信息*/
function SetShowAttr(dataId, showAttr, url) {
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'dataId': dataId, 'showAttr': showAttr },
        dataType: "text",
        success: function (data) {
            //alert(data);
            console.log(data);
            location.reload();
            //console.log('成功');
            //console.log(data);
        },
        error: function (data) {
            alert('修改出现了问题，请联系管理员');
            location.reload();
        }
    });
}
