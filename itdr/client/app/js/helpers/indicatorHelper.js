indicatorHelper = [];

// request object creation
indicatorHelper.createDeleteIndicatorRequestObject = function (subjectId, userIdentifier, userIndicatorId) {
    var request = {
        subjectId: subjectId,
        userIdentifier: userIdentifier,
        userIndicatorId: userIndicatorId
    };

    return JSON.stringify(request);
};

indicatorHelper.createCreateIndicatorRequestObject = function (indicator) {
    var request = {
        indicator: indicator
    };

    return JSON.stringify(request);
};

indicatorHelper.createQueryRequestObject = function (indicators, timeLevel, geographyLevel) {
    var indicatorIds = _.pluck(indicators, "userIndicatorId");
    var request = {
        timeLevel: timeLevel,
        geographyLevel: geographyLevel,
        indicatorIds: indicatorIds
    };

    return JSON.stringify(request);
};
