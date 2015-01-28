httpHelper = [];

httpHelper.getUniqueIdentifier = function () {
    var id = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
    return id;
};

httpHelper.formatEquationForHttp = function (equation) {
    equation = equation.replace('+', '-1');
    equation = equation.replace('/', '-3');
    equation = equation.replace('*', '-4');
    equation = equation.replace('(', '-5');
    equation = equation.replace(')', '-6');
    return equation;
};

httpHelper.removeHttpFormatting = function (equation) {
    equation = equation.replace('-1', '+');
    equation = equation.replace('-2', '/');
    equation = equation.replace('-3', '*');
    equation = equation.replace('-4', '(');
    equation = equation.replace('-5', ')');
    return equation;
};
