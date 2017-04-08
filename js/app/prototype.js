Array.prototype.in_array = function (value) {
	for (var i=0; i<this.length; i++) {
		if (this[i] == value) {
			return true;
		}
	}
	return false;
}

Array.prototype.addArray = function (inArray) {
	if (typeof(inArray) != "undefined") {
		for (var i=0; i<inArray.length; i++) {
			this.push(inArray[i]);
		}
	}
	return this;
};

Array.prototype.array_index = function (value) {
	for (var i=0; i<this.length; i++) {
		if (this[i] == value) {
			return i;
		}
	}
	return -1;
};

Array.prototype.implode = function (separator) {
	var output = "";
	var sep = "";
	for (var i=0; i<this.length; i++) {
		output += sep + this[i];
		sep = separator;
	}
	return output;
};
	
Array.prototype.last = function () {
	return this[this.length - 1];
};

Array.prototype.remove = function (index) {
	this.splice(index,1);
};

Date.prototype.format = function (formatStr) {
	var weekDays = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	var monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];	
	var formatted = "";
	var d = this;
	var theMonth = d.getMonth() + 1;
	var theHour = d.getHours();
	var theMinute = d.getMinutes();
	var theSecond = d.getSeconds();
	var theDate = d.getDate();
	var theWeekDay = "";
	var monthName = "";
	var ampm = (theHour < 12) ? "AM" : "PM";
	var twelveHour = (theHour > 12) ? theHour - 12 : theHour;
	twelveHour = (twelveHour == 0) ? 12 : twelveHour;
	if ((formatStr.indexOf("D") != -1 || formatStr.indexOf("l") != -1) && !isNaN(d.getDay())) {
		theWeekDay = weekDays[d.getDay()];
		theWeekDay = theWeekDay;
	}
	if ((formatStr.indexOf("M") != -1 || formatStr.indexOf("F") != -1)) {
		monthName = monthNames[theMonth - 1];
	}

	var dParts = {
		G: theHour,
		H: (theHour < 10) ? theHour : theHour,
		I: (theMinute < 10) ? theMinute : theMinute,
		g: twelveHour,
		h: (twelveHour < 10) ? "0" + twelveHour : twelveHour,
		i: (theMinute < 10) ? "0" + theMinute : theMinute,
		s: (theSecond < 10) ? "0" + theSecond : theSecond,
		A: ampm,
		a: ampm.toLowerCase(),
		l: theWeekDay,
		D: theWeekDay.substr(0,3),
		F: monthName,
		M: monthName.substr(0,3),
		j: theDate,
		Y: d.getFullYear(),
		m: (theMonth < 10) ? "0" + theMonth : theMonth,
		d: (theDate < 10) ? "0" + theDate : theDate
	};
	for (var i=0; i<formatStr.length; i++) {
		var c = formatStr[i];
		formatted += (dParts.hasOwnProperty(c)) ? dParts[c] : c;
	}
	return formatted;
}

Number.prototype = function toDollar() {
	return this.toString().toDollar();
}

String.prototype.guid = function () {
    var S4 = function() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

String.prototype.addNumericSuffix = function (inNumber) {
	var suffix = "";
	var base = "";
	var outString = "";
	for (var i=this.length; i>0; i--) {
		var char = this.substr(i-1,1);
		if (char.search(/[0-9]/) != -1) {
			suffix = char + suffix;
			base = this.replace(suffix,"");
		}
	}
	if (suffix == "") {
		suffix = (typeof(inNumber) != "undefined") ? "_" + inNumber : "_1";
		outString = this + suffix;
	} else {
		var number = (typeof(inNumber) != "undefined") ? inNumber : parseInt(suffix.replace("_",""),10) + 1;
		if (isNaN(number)) {
			number = "1";
		}
		outString = base + number;
	}
	return outString;
}

String.prototype.deleteNumericSuffix = function () {
	var newString = this.toString();
	for (var i=this.length; i>0; i--) {

		var char = this.substr(i-1,1);
		if (char.search(/[0-9_]/) != -1) {
			newString = newString.substr(0,i-1);
		}
	}
	return newString;
}

String.prototype.getSuffixNumber = function () {
	var suffix = "";
	for (var i=this.length; i>0; i--) {
		var char = this.substr(i-1,1);
		if (char.search(/[0-9_]/) != -1) {
			suffix = char + suffix;
		}
	}
	return suffix.replace("_","");
}

String.prototype.fromISODate = function () {
	//*** If the date is 0000-00-00, return a blank
	if (this.replace(/[^1-9]/g,"") == "") {
		return "";
	}
	var dateParts = this.split("-");
	return dateParts[1] + "/" + dateParts[2] + "/" + dateParts[0];
}

String.prototype.toDollar = function () {
	var nums = this.replace(/[^0-9\.]/g,"");
	nums = parseFloat(nums).toFixed(2);
	if (isNaN(nums)) {
		return "0.00";
	}
	return nums.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

String.prototype.toNumber = function () {
	return this.replace(/[^0-9\.]/g,'');
}

String.prototype.toProperCase = function () {
    return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

String.prototype.truncate = function (maxLen) {
	var short = this.substr(0,maxLen) + "...";
	return (this.length < maxLen) ? this : this.substr(0,maxLen) + "...";
}

String.prototype.deEscape = function () {
	var text = this;
	text = text.replace(/\\'/g,"'");
	return text;
}

String.prototype.fromISODate = function (formatStr) {
	//*** If the date is 0000-00-00, return a blank
	if (this.replace(/[^1-9]/g,"") == "") {
		return "";
	}
	var dateParts = this.split("-");
	var converted = dateParts[1] + "/" + dateParts[2] + "/" + dateParts[0];
	if (typeof(formatStr) != "undefined") {
		var d = new Date(converted);
		converted = d.format(formatStr);
	}
	return converted;
}

String.prototype.fromISODateTime = function (timeFormat, dateFormat) {
	var dateParts = this.split(" ");
	var theDate = dateParts[0].fromISODate("M d, Y");
	var theTime = dateParts[1].fromISOTime("g:i A");
	return theDate + " " + theTime;
}

String.prototype.fromISOTime = function (formatStr) {
	var d = new Date();
	var timeParts = this.split(":");
	
	d.setHours(timeParts[0]);
	d.setMinutes(timeParts[1]);
	if (timeParts.length == 3) {
		d.setSeconds(timeParts[2]);
	}
	return d.format(formatStr);
}

String.prototype.ucwords = function() {
	return (this + '').replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function ($1) {
		return $1.toUpperCase();
	});
}

function getObjectLength(obj) {
	var count = 0;

	for (i in obj) {
	    if (obj.hasOwnProperty(i)) {
		   count++;
	    }
	}
	return count;
}
