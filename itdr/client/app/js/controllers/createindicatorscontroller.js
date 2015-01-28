appControllers.controller('CreateIndicatorsCtrl',
  function ($scope, $routeParams, $http, webApiUrl, ngTableParams) {
      var salt = httpHelper.getUniqueIdentifier();
      $http.get(webApiUrl.concat('fields.php?subjectid=1&salt=' + salt), { cache: false }).success(function (data) {
          // categories of fields
          $scope.draggableFieldObjects1 = new Array();
          $scope.draggableFieldObjects2 = new Array();
          $scope.draggableFieldObjects3 = new Array();
          $scope.draggableFieldObjects4 = new Array();

          var diagnosisFields = ['malariadx', 'malariadxa', 'ispregnant', 'feverless2', 'confirmedcase'];
          var treatmentFields = ['chloroquine', 'quinine', 'primaquine','alltreatments','singletreatment', 'anytreatment'];
          var testingFields = ['rapidresultpositive', 'rapidresultnegative', 'smearresultpositive', 'smearresultnegative', 'ft', 'fg', 'vx', 'ov', 'mai', 'positivefalciparumtest', 'positiveotherparasitetest'];

          data.fields.forEach(function (obj) {
              var fieldName = obj.fieldName;              
              if ($.inArray(fieldName, diagnosisFields) != -1) {
                  obj.isField = 1;
                  $scope.draggableFieldObjects1.push(obj);
              }
              else if ($.inArray(fieldName, treatmentFields) != -1) {
                  obj.isField = 1;
                  $scope.draggableFieldObjects2.push(obj);
              }
              else if ($.inArray(fieldName, testingFields) != -1) {
                  obj.isField = 1;
                  $scope.draggableFieldObjects3.push(obj);
              }
          });

          //TODO-the denominator should be handled like the numerator(in the db) once they are defined.
          // I am just manually handling one case(all patients)
          var allPatientsField = { fieldId: -1, fieldName: "allpatients", fieldDisplayName: "All Patients", isField: true };
          $scope.draggableFieldObjects4.push(allPatientsField);

          $scope.reset();
      });

      $scope.reset = function () {
          $scope.userIndicatorName = '';
          $scope.numeratorEquation = '';
          $scope.denominatorEquation = '';
          $scope.selectedAgeLevel = $scope.ageLevels[0];
          $scope.selectedGenderLevel = $scope.genderLevels[0];
          $scope.firstNumeratorField = [];
          $scope.numeratorOperator = [];
          $scope.secondNumeratorField = [];
          $scope.firstDenominatorField = [];
          $scope.denominatorOperator = [];
          $scope.secondDenominatorField = [];
          $scope.indicatorIsValid = false;
      };

      $scope.subjectName = 'Malaria';
      $scope.userIdentifier = 'User 1';
      $scope.userIndicatorName = '';
      $scope.numeratorEquation = '';
      $scope.denominatorEquation = '';
      $scope.selectedAgeLevel = [];
      $scope.selectedGenderLevel = [];
      $scope.genderLevels = lookups.genderLevels;
      $scope.ageLevels = lookups.ageLevels;
      $scope.firstNumeratorField = [];
      $scope.numeratorOperator = [];
      $scope.secondNumeratorField = [];
      $scope.firstDenominatorField = [];
      $scope.denominatorOperator = [];
      $scope.secondDenominatorField = [];
      $scope.draggableOperatorObjects = lookups.operators;
      $scope.draggableFieldObjects1 = [];
      $scope.draggableFieldObjects2 = [];
      $scope.draggableFieldObjects3 = [];
      $scope.draggableFieldObjects4 = [];
      // TODO: handle validation before indicator is allowed to be created.
      $scope.indicatorIsValid = false;

      // Data modification
      $scope.createIndicator = function () {
          var indicator = {
              userIndicatorTypeId: 2,
              userIndicatorName: $scope.userIndicatorName,              
              ageLevel: $scope.selectedAgeLevel.value,
              genderLevel: $scope.selectedGenderLevel.value,
              numeratorEquation: httpHelper.formatEquationForHttp($scope.numeratorEquation),
              denominatorEquation: httpHelper.formatEquationForHttp($scope.denominatorEquation),
              subjectId: 1,
              userIdentifier: $scope.userIdentifier
          };
          
          var obj = indicatorHelper.createCreateIndicatorRequestObject(indicator);
          var request = "requestJson=" + obj;

          // send to database
          $http({
              method: 'POST',
              url: webApiUrl.concat('createuserindicator.php'),
              data: request,
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              cache: false
          }).success(function (data) {
              $scope.reset();
          });
      };
      
      // Drag actions
      $scope.onDropComplete = function (data, evt, dropBoxName) {
          var dropBoxCollection = $scope[dropBoxName];
          $scope.addObjectToDropBox(dropBoxCollection, dropBoxName, data);
      };
      
      $scope.onDragSuccess = function(data, evt, dropBox) {
          var index = $scope.droppedObjects.indexOf(data);
          if (index > -1) {
              $scope.droppedObjects.splice(index, 1);
          }
      };

      $scope.addObjectToDropBox = function(dropBoxCollection, dropBoxName, obj) {
          if (dropBoxCollection.length != 0) {
              return;
          }

          if (dropBoxName.indexOf("Field") != -1) {
              if (obj.isField != 1) {
                  return;
              }
          } else {
              if (obj.isField == 1) {
                  return;
              }
          }

          dropBoxCollection.push(obj);
          $scope.numeratorEquation = $scope.generateEquationPart("Numerator");
          $scope.denominatorEquation = $scope.generateEquationPart("Denominator");
      };

      $scope.generateEquationPart = function(partString) {
          var partialEquation = '';
          var firstField = 'first' + partString + 'Field';
          var operator = partString.toLowerCase() + 'Operator';
          var secondField = 'second' + partString + 'Field';

          if ($scope[firstField]!='undefined' && $scope[firstField].length == 1) {
              partialEquation = $scope.createFormattedField($scope[firstField][0].fieldName);
          }
          if ($scope[secondField] != 'undefined' && $scope[secondField].length == 1) {
              if ($scope[operator] != 'undefined' && $scope[operator].length == 1) {
                  partialEquation += $scope.createFormattedOperator($scope[operator][0].fieldDisplayName);
              }
              partialEquation += $scope.createFormattedField($scope[secondField][0].fieldName);
          }
          return partialEquation;
      };

      $scope.createFormattedField = function(fieldName) {
          return '{' + fieldName + '}';         
      };

      $scope.createFormattedOperator = function (operatorSymbol) {
          return ' ' + operatorSymbol + ' ';
      };
  });
