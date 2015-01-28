var lookups = {};

//TODO: get these through ajax call because they will change often
lookups.subjects = [
    {
        'name': 'Malaria',
        'value': '1'
    },
    {
        'name': 'Subject2',
        'value': '2'
    },
    {
        'name': 'Subject3',
        'value': '3'
    }
];
lookups.geographyLevels = [
    {
        'name': 'All',
        'value': '0'
    },
    {
        'name': 'Department',
        'value': '2'
    },
    {
        'name': 'Clinic',
        'value': '3'
    }
];
lookups.timeLevelsForRunIndicators = [
    {
        'name': 'Year',
        'value': '1'
    },
    {
        'name': 'Quarter',
        'value': '2'
    },
    {
        'name': 'Month',
        'value': '3'
    },
    {
        'name': 'Week',
        'value': '4'
    }
];

lookups.timeLevelsForDataOverview = [
    {
        'name': 'Year',
        'value': '1'
    },
    {
        'name': 'Quarter',
        'value': '2'
    },
    {
        'name': 'Month',
        'value': '3'
    },
    {
        'name': 'Week',
        'value': '4'
    }
];

lookups.ageLevels = [
  {
      'name': 'All',
      'value': '0'
  },
  {
      'name': 'LT1',
      'value': '1'
  },
  {
      'name': '1-4',
      'value': '2'
  },
  {
      'name': '5-9',
      'value': '3'
  },
  {
      'name': '10-14',
      'value': '4'
  },
  {
      'name': '15-24',
      'value': '5'
  },
  {
      'name': '25-49',
      'value': '6'
  },
  {
      'name': 'GT49',
      'value': '7'
  }
];

lookups.genderLevels = [
  {
      'name': 'All',
      'value': '0'
  },
  {
      'name': 'Male',
      'value': '1'
  },
  {
      'name': 'Female',
      'value': '2'
  }
];

lookups.operators = [
          //TODO: support these
          //{ 'fieldDisplayName': "+", value: -1, IsField: 0 },
          //{ 'fieldDisplayName': "-", value: -2, IsField: 0 },
          { 'fieldDisplayName': "AND", value: -7, IsField: 0 },
          { 'fieldDisplayName': "OR", value: -8, IsField: 0 },
          { 'fieldDisplayName': "NOT", value: -9, IsField: 0 }
];

