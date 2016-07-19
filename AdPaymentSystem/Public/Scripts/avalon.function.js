//省份
var provinceList = new Array();
$.ajax({
    url: '/index.php/Common/provinceList',
    type: 'get',
    dataType: "json",
    async: true,
    data: { r: Math.random() },
    success: function (data) {
        provinceList = data;
    }
});
avalon.filters.province = function (v) {
    for (var i = 0; i < provinceList.length; i++) {
        if (provinceList[i]['key'] == v) return provinceList[i]['value'][0];
    }
};


/*省市联动,城市*/
var cityList = new Array();
avalon.filters.city = function (provinceID, v) {
    $.ajax({
        url: '/index.php/Common/CityList',
        type: 'get',
        dataType: "json",
        async: true,
        data: { r: Math.random(), provinceID: provinceID },
        success: function (data) {
            cityList = data;
        }
    });
    for (var i = 0; i < cityList.length; i++) {
        if (cityList[i]['key'] == v) return cityList[i]['value'][0];
    }
};


//人员职位
//managerList = [[0, "员工"], [3, '主管'], [4, '副经理'], [1, '经理'], [5, '副总监'], [2, '总监'], [6, '主任'], [7, '总经理助理'], [8, '副总经理'], [9, '总经理']];
var managerList = getarrbyjson("/Public/JsonData/managerList.json");
avalon.filters.manager = function (v) {
    for (var i = 0; i < managerList.length; i++) {
        if (managerList[i][0] == v) return managerList[i][1];
    }
};


//学习形式
var learningFormList = new Array();
//learningFormList = [[1, "正规高等院校"], [2, '高等教育自学考试'], [3, '夜大学'], [4, '职工大学'], [5, '电视大学'], [6, '业余大学'], [7, '函授'], [8, '研学班'], [9, '高等学校进修'], [10, '培训'], [11, '其他']];
learningFormList = getarrbyjson("/Public/JsonData/learningFormList.json");
avalon.filters.learningForm = function (v) {
    for (var i = 0; i < learningFormList.length; i++) {
        if (learningFormList[i][0] == v) return learningFormList[i][1];
    }
};

//学历学位
var educationDegreeList = new Array();
//educationDegreeList = [[1, "文盲"], [2, '小学'], [3, '初中'], [4, '高中'], [5, '大专'], [6, '本科'], [7, '硕士'], [8, '博士']];
educationDegreeList = getarrbyjson("/Public/JsonData/educationDegreeList.json");
avalon.filters.educationDegree = function (v) {
    for (var i = 0; i < educationDegreeList.length; i++) {
        if (educationDegreeList[i][0] == v) return educationDegreeList[i][1];
    }
};

//外语水平
var foreignLanguageLevelList = new Array();
//foreignLanguageLevelList = [[1, "三级"], [2, '四级'], [3, '六级'], [4, '八级'], [5, '专四'], [6, '专六'], [7, '专八']];
foreignLanguageLevelList = getarrbyjson("/Public/JsonData/foreignLanguageLevelList.json");
avalon.filters.foreignLanguageLevel = function (v) {
    for (var i = 0; i < foreignLanguageLevelList.length; i++) {
        if (foreignLanguageLevelList[i][0] == v) return foreignLanguageLevelList[i][1];
    }
};

//户籍种类
var householdTypeList = new Array();
//householdTypeList = [[0, "非农业户口"], [1, "农业户口"], [2, '港澳台'], [3, '外籍'], [4, '其他']];
householdTypeList = getarrbyjson("/Public/JsonData/householdTypeList.json");
avalon.filters.householdType = function (v) {
    for (var i = 0; i < householdTypeList.length; i++) {
        if (householdTypeList[i][0] == v) return householdTypeList[i][1];
    }
};

//政治面貌
var politicalStatusList = new Array();
//politicalStatusList = [[1, "群众"], [2, '共青团员'], [3, '预备党员'], [4, '党员']];
politicalStatusList = getarrbyjson("/Public/JsonData/politicalStatusList.json");
avalon.filters.politicalStatus = function (v) {
    for (var i = 0; i < politicalStatusList.length; i++) {
        if (politicalStatusList[i][0] == v) return politicalStatusList[i][1];
    }
};

//证件类型
var documentTypeList = new Array();
//documentTypeList = [[1, "公民身份证"], [2, '护照'], [3, '社会保障卡'], [4, '其他']];
documentTypeList = getarrbyjson("/Public/JsonData/documentTypeList.json");
avalon.filters.documentType = function (v) {
    for (var i = 0; i < documentTypeList.length; i++) {
        if (documentTypeList[i][0] == v) return documentTypeList[i][1];
    }
};

//在职离职状态
var ischeckedList = new Array();
//ischeckedList = [[0, '离职'], [1, '在职']];
ischeckedList = getarrbyjson("/Public/JsonData/ischeckedList.json");
avalon.filters.ischecked = function (v) {
    for (var i = 0; i < ischeckedList.length; i++) {
        if (ischeckedList[i][0] == v) return ischeckedList[i][1];
    }
};

//转正状态
var positiveList = new Array();
//positiveList = [[0, '未转正'], [1, '已转正']];
positiveList = getarrbyjson("/Public/JsonData/positiveList.json");
avalon.filters.positive = function (v) {
    for (var i = 0; i < positiveList.length; i++) {
        if (positiveList[i][0] == v) return positiveList[i][1];
    }
};

//加薪类型
var payList = new Array();
//payList = [[0, '转正加薪'], [1, '普通加薪'], [2, '调岗加薪'], [3, '升职加薪']];
payList = getarrbyjson("/Public/JsonData/payList.json");

var normalPayList = new Array();
//normalPayList = [[0, '转正加薪'], [1, '普通加薪']];
normalPayList = getarrbyjson("/Public/JsonData/normalPayList.json");

var specialPayList = new Array();
//specialPayList = [[2, '调岗加薪'], [3, '升职加薪']];
specialPayList = getarrbyjson("/Public/JsonData/specialPayList.json");
avalon.filters.pay = function (v) {
    for (var i = 0; i < payList.length; i++) {
        if (payList[i][0] == v) return payList[i][1];
    }
};

//考勤类型
var leaveTypeList = new Array();
//leaveTypeList = [[0, '迟到早退'], [1, '事假'], [2, '病假'], [3, '婚假'], [4, '丧假'], [5, '产假'], [6, '陪产假'],[7, '年假']];
leaveTypeList = getarrbyjson("/Public/JsonData/leaveTypeList.json");
avalon.filters.leaveType = function (v) {
    for (var i = 0; i < leaveTypeList.length; i++) {
        if (leaveTypeList[i][0] == v) return leaveTypeList[i][1];
    }
};

//补回天数
avalon.filters.returnDays = function (LeaveType, LeaveDays) {
    var ReturnDays=0;
    if (LeaveType == 2 && LeaveDays > 0) //病假且请假半天以上的，计算补回天数
    {
        if (LeaveDays >= 3)
            ReturnDays = 1.5;
        else if (LeaveDays == 2.5 || LeaveDays == 2)
            ReturnDays = 1;
        else if (LeaveDays == 1.5 || LeaveDays == 1 || LeaveDays == 0.5)
            ReturnDays = 0.5;
    }
    else if (LeaveType == 3 || LeaveType == 4) //婚假,丧假
    {
        if (LeaveDays >= 3)
            ReturnDays = 3;
        else if (LeaveDays < 3)
            ReturnDays = LeaveDays;
    }
    else if (LeaveType == 5 || LeaveType == 6) //产假，陪产假
    {
        ReturnDays = LeaveDays;
    }
    ReturnDays = ReturnDays == 0 ? 0 : ReturnDays;
    return ReturnDays;
};

//关于备注的过滤器,data数据的长度超过限定长度就会显示缩略数据,默认为20
avalon.filters.shortNote = function (data, length) {
    if (data.length > length)
        return avalon.filters.truncate(data, length) + "<a data-container=\"body\" data-toggle=\"popover\" data-placement=\"top\" data-content=\"" + data.toString() + "\">详细</a>";
    else
        return data;
};

//毕业类型
var graguatedList = new Array();
//graguatedList = [[0, '未毕业'], [1, '已毕业']];
graguatedList = getarrbyjson("/Public/JsonData/graguatedList.json");
avalon.filters.graguated = function (v) {
    for (var i = 0; i < graguatedList.length; i++) {
        if (graguatedList[i][0] == v) return graguatedList[i][1];
    }
};

//医疗本领取
var yrbList = new Array();
//yrbList = [[0, '否'], [1, '是']];

//根据json获取相关对象并转换为二维数组
function getarrbyjson(filepath) {
    $.ajaxSettings.async = false;
    var Object = [];
    var arr = new Array();
    $.getJSON(filepath, function (data) {
        Object = data;
    });
    //console.log(Object);
    var i = 0;
    for (var each in Object) {
        for (var each1 in Object[each]) {
            arr[i] = [each1, Object[each][each1]];
            i++;
        }
    }
    $.ajaxSettings.async = true;
    return arr;
};