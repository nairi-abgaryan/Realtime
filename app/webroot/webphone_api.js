/** 
* You can control the webphone using the API functions below
*/

var webphone_api = (function ()
{

/** 
* Configuration settings can be specified below
* (you can also set the parameters at runtime by using the setparameter() function)
*/
var parameters = {
                    sdk: false, // set to true, only if used as SDK
                    //serveraddress: '', // your VoIP server IP address or domain name. Leave it empty if using tunneling
                    //upperserver: '' // applicable only when using tunneling
                    //sipusername: '', // preconfigured SIP account username
                    //password: '', // preconfigured SIP account password
                    
                    // See the documentation for the complete parameter list 
                 };


/** 
* call this function once and pass a callback, to receive important events, 
* which should be displayed for the user and/or parsed to perform other actions
*/

/*
Example:
webphone_api.getEvents( function (event)
{
    // For example the following status means that there is an incoming call ringing from 2222 on the first line:
    // STATUS,1,Ringing,2222,1111,2,Katie,[callid]
    // parameters are separated by comma(,)
    // the sixth parameter (2) means it's incoming call. For outgoing call it's: 1.
    // You can find more detailed explanation about events in the documentation
    
    // example for detecting incoming and outgoing calls:
    
    var evtarray = event.split(',');
    
    if (evtarray[0] === 'STATUS' && evtarray[2] === 'Ringing')
    {
        if (evtarray[5] === '1')
        {
            // means it's outgoing call
            // ...
        }
        else if (evtarray[5] === '1')
        {
            // means it's icoming call
            // ...
        }
    }
});
*/

function getEvents (callback)
{
    if ( !callback || typeof (callback) !== 'function' ) { return; }

    evcb = callback;
}

/** 
* start the phone (register to your voip server)
* any additional parameters must be set before calling start(). Use setparameter(param, value) function for this.
*/
function start (username, password) // boolean
{
    return plhandler.Start(username, password, parameters);
}

/** Initiate call to a number or sip username.*/
function call (line, number, name) // boolean
{
    return plhandler.Call(line, number, name);
}

/** Disconnect current call(s). If you set -2 for the line parameter, then all calls will be disconnected (in case if there are multiple calls in progress)*/
function hangup (line) // boolean
{
    return plhandler.Hangup(line);
}

/** Connect incoming call*/
function accept (line) // boolean
{
    return plhandler.Accept(line);
}

/** Disconnect incoming call.*/
function reject (line) // boolean
{
    return plhandler.Reject(line);
}

/** 
* Add people to conference.
* If number is empty than will mix the currently running calls (if there is more than one call)
* Otherwise it will call the new number (usually a phone number or a SIP user name) and once connected will join with the current session.
*/
function conference (line, number) // boolean
{
    return plhandler.Conference(line, number);
}

/** 
* Transfer current call to number which is usually a phone number or a SIP username. (Will use the REFER method after SIP standards).
* You can set the mode of the transfer with the “transfertype” applet parameter.
*/
function transfer (line, number) // boolean
{
    return plhandler.Transfer(line, number);
}

/** 
* Send DTMF message by SIP INFO or RFC2833 method (depending on the “dtmfmode” applet parameter).
* Please note that the dtmf parameter is a string. This means that multiple dtmf characters can be passed at once
* and the webphone will streamline them properly. Use the space char to insert delays between the digits.
* The dtmf messages are sent with the protocol specified with the “dtmfmode” applet parameter.
* Example:	API_Dtmf(-2,” 12 345 #”);
*/
function dtmf (line, dtmf) // boolean
{
    return plhandler.Dtmf(line, dtmf);
}

/** 
*  Mute current call. The direction can have the following values:
*   0:  mute in and out 
*	1:  mute out (speakers)
*	2: mute in (microphone)
*	3: mute in and out (same as 0)
*/
function mute (line, mute, direction) // boolean
{
    return plhandler.MuteEx(line, mute, direction);
}

/** 
* Hold current call. This will issue an UPDATE or a reINVITE.
* Set the second parameter to true for hold and false to reload.
*/

function hold (line, hold) // boolean
{
    return plhandler.Hold(line, hold);
}

/** 
* Send a chat message. (SIP MESSAGE method after RFC 3428)
* Peer can be a phone number or SIP username/extension number.
*/
function sendchat (line, number, msg) // boolean
{
    return plhandler.SendChat(line, number, msg);
}

/** Open audio device selector dialog (built-in user interface).*/
function audiodevice()
{
    return plhandler.AudioDevice();
}

/** 
* Set volume (0-100%) for the selected device. Default value is 50% -> means no change
* The dev parameter can have the following values:
*  0 for the recording (microphone) audio device
*  1 for the playback (speaker) audio device
*  2 for the ringback (speaker) audio device
*/
function setvolume(dev, volume)
{
    return plhandler.SetVolume(dev, volume);
}

/** any additional parameters must be set before start() is called*/
function setparameter (param, value)  // boolean
{
    return plhandler.SetParameter(param, value);
}

/** Return true if the webphone is registered ("connected") to the SIP server.*/
function isregistered ()
{
    return plhandler.IsRegistered();
}

/** 
* specify callfunction buttons displayed on bottom of page, while in call
* possible values (separated by comma): conference,transfer,numpad,mute,hold,chat
*/
function GetAvailableCallfunctions ()
{
    var callfunctions = 'conference,transfer,numpad,mute,hold,chat';

    return callfunctions;
}

/** 
* will recive presence infomation as events: PRESENCE, status,username,displayname,email   (displayname and email can be empty)
* userlist: list of sip account username separated by comma
*/
function checkpresence (userlist)
{
    return plhandler.CheckPresence(userlist);
}

/** function call to change the user online status with one of the followings strings: Online, Away, DND, Invisible , Offline (case sensitive)*/
function setpresencestatus(statustring)
{
    return plhandler.SetPresenceStatus (statustring);
}

/** check if communication channel is encrypted: -1=unknown, 0=no, 1=partially, 2=yes, 3=always*/
function isencrypted()
{
    return plhandler.IsEncrypted ();
}

//***************** public API END *********************























//***************** Private helper functions. Don't use and don't touch this *********************
var evcb = null;

function RecEvt (ev) // helper function
{
    if ( !evcb || typeof (evcb) !== 'function' ) { return; }

    evcb(ev);
}

function InsertApplet(apltstr)
{
    plhandler.InsertApplet(apltstr);
}

// called from windows softphone - on Enter key pressed
function enterkeypress()
{
    return plhandler.EnterKeyPress();
}

function bwanswer(answer)
{
    plhandler.bwanswer(answer);
}

function onappexit() // called right before windows softphone exists
{
    plhandler.onappexit();
}

function getlogs() // called from windows softphone; send logs to softphone API_SetLogs(String)
{
    plhandler.getlogs();
}

function delsettings() // delete all stored data (from cookie and localforage): settings, contacts, callhistory, messages
{
    plhandler.delsettings();
}

function needratingrequest(callback) // returns true, if rating need to be called
{
    plhandler.needratingrequest(callback);
}

// display help popup
function helpwindow ()
{
    return plhandler.HelpWindow();
}

// go to/open Settings page
function settingspage ()
{
    return plhandler.SettingsPage();
}

// go to/open Dial pad page
function dialpage ()
{
    return plhandler.DialPage();
}

// go to/open Message inbox page
function messageinboxpage ()
{
    return plhandler.MessageInboxPage();
}

// go to/open Message page
function messagepage ()
{
    return plhandler.MessagePage();
}

// go to/open Add contact page
function addcontact ()
{
    return plhandler.AddContact();
}


var browserName = null; // browser family
var browserName2 = null; // browser name

function GetBrowser () // function from deployjava.js; returns the browser name
{
    try{

    if (isNull(browserName) || isNull(browserName2))
    {
        var browser = navigator.userAgent.toLowerCase();
        
        // order is important here.  Safari userAgent contains mozilla,
        // IE 11 userAgent contains mozilla and netscape, 
        // and Chrome userAgent contains both mozilla and safari.
        if ((browser.indexOf('msie') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'MSIE';
            browserName2 = 'MSIE';
        }
        else if (browser.indexOf('trident') !== -1 || browser.indexOf('Trident') !== -1)
        {
            browserName = 'MSIE';
            browserName2 = 'MSIE';
        }
        else if (browser.indexOf('iphone') !== -1)
        {
            // this included both iPhone and iPad
            browserName = 'Netscape Family';
            browserName2 = 'iPhone';
        }
        else if ((browser.indexOf('firefox') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'Netscape Family';
            browserName2 = 'Firefox';
        }
        else if (browser.indexOf('chrome') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Chrome';
        }
        else if (browser.indexOf('safari') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Safari';
        }
        else if ((browser.indexOf('mozilla') !== -1) && (browser.indexOf('opera') === -1))
        {
            browserName = 'Netscape Family';
            browserName2 = 'Other';
        }
        else if (browser.indexOf('opera') !== -1)
        {
            browserName = 'Netscape Family';
            browserName2 = 'Opera';
        }else
        {
            browserName = '?';
            browserName2 = 'unknown';
        }
    }
    } catch(err) { alert('ERROR, wphone: GetBrowser'); }
    
    return browserName2;
}

var browserversion = -1;
function GetBrowserVersion () // :int, main version
{
    try{
    if (browserversion > 0) { return browserversion; }
    
    var bname = GetBrowser();
    var bv = navigator.userAgent.toLowerCase();

    if (bname === 'Chrome')
    {
        var pos = bv.indexOf('chrome');
        if (pos > 0) { bv = bv.substring(pos + 6); }
        
        if (!isNull(bv)) { bv = bv.replace('/', ''); }
        
        pos = bv.indexOf('.');
        if (pos > 0) { bv = bv.substring(0, pos); }
        
        if (!isNull(bv))
        {
            bv = Trim(bv);
            
            if (IsNumber(bv))
            {
                browserversion = StrToInt(bv);
            }
        }
    }
    } catch(err) { alert('ERROR, wphone: GetBrowserversion'); }
    
    return browserversion;
}

function isNull (variable)
{
    try{
    if (typeof (variable) === 'undefined' || variable === null)
    {
        return true;
    }else
    {
        return false;
    }
    } catch(err) { alert("ERROR, wphone: isNull"); }
    
    return true;
}

function Trim(str)
{
    try{
    if (isNull(str) || str.lenght < 1) { return ''; }
    
    str = str.toString();
    return str.replace(/^\s+|\s+$/g, ''); 
    
    } catch(err) { alert("ERROR, wphone: Trim"); }
    
    return str;
}

function IsNumber (value)
{
    try{
    //return (typeof value === 'number' && isFinite(value));
    if (typeof(value) === 'undefined' || value == null) { return false; }
    
    value = value.toString();
    value = value.replace(/\s+/g, '');

    if (value == null || value.length < 1) { return false; }

    return !isNaN(value);
    
    } catch(err) { alert("ERROR, wphone: IsNumber"); }
    
    return false;
}

function StrToInt (value) // convert String to Integer, only numerical string is accepted
{
    try{
    if ( isNull(value) || !IsNumber(value))
    {
        return null;
    }else
    {
//        value = ReplaceAll(value, ' ', '');
        return parseInt(value,10);
    }
    } catch(err) { PutToDebugLogException(2, "common: StrToInt", err); }
    
    return null;
}

var wphone = {
    getEvents: getEvents,
    start: start,
    call: call,
    hangup: hangup,
    accept: accept,
    reject: reject,
    conference: conference,
    transfer: transfer,
    dtmf: dtmf,
    mute: mute,
    hold: hold,
    sendchat: sendchat,
    audiodevice: audiodevice,
    setvolume: setvolume,
    setparameter: setparameter,
    isregistered: isregistered,
    GetAvailableCallfunctions: GetAvailableCallfunctions,
    helpwindow: helpwindow,
    settingspage: settingspage,
    dialpage: dialpage,
    messageinboxpage: messageinboxpage,
    messagepage: messagepage,
    addcontact: addcontact,
    checkpresence: checkpresence,
    setpresencestatus: setpresencestatus,
    isencrypted: isencrypted,
    RecEvt: RecEvt,
    InsertApplet: InsertApplet,
    enterkeypress: enterkeypress,
    bwanswer: bwanswer,
    onappexit: onappexit,
    getlogs: getlogs,
    delsettings: delsettings,
    needratingrequest: needratingrequest,
    GetBrowser: GetBrowser,
    GetBrowserVersion: GetBrowserVersion,
    parameters: parameters
};
//window.wphone = wphone;
return wphone;
})();

// redirect to old skin in case of IE6 and 7

function IsIeVersion (version) // :boolean  check if it is IE browser version xxx
{
    try{
    if (version === null) { return false; }

    var agent = navigator.userAgent;
    var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
    var matches = agent.match(reg);
    
    if (typeof (matches) !== 'undefined' && matches !== null
            && typeof (matches[0]) !== 'undefined' && matches[0] !== null && matches[0].indexOf(version) >= 0)
    {
        return true;
    }

    } catch(err) { alert ('wphone IsIeVersion: ' + err); }
    return false;
}


var isie8iframe = false;
try{
    if (IsIeVersion(8) && window.self !== window.top)
    {
        isie8iframe = true;
    }
} catch(err) { }
if (IsIeVersion(6) || IsIeVersion(7) || isie8iframe)
{
    window.location.href = "old_skin/webphone_api.htm";
}

// handle flash phone red5phone
//window.location.href = "flash/fphone.html";


//RELEASE
/*
document.write('<script type="text/javascript" src="js/lib/sipml5_api.js"></script>'); //#BUILD 
document.write('<script type="text/javascript" src="js/lib/swfobject.js"></script>'); //#BUILD 
document.write('<script type="text/javascript" src="js/lib/config.js"></script>'); //#BUILD 

if (webphone_api.GetBrowser() !== 'Chrome'
    || (webphone_api.GetBrowser() === 'Chrome' && webphone_api.GetBrowserVersion() < 42))
{
    document.write('<script type="text/javascript" src="js/lib/mwpdeploy.js"></script>');
}
document.write('<script data-main="js/lib/main" src="js/lib/require.js"></script>');
*/
//ENDRELEASE



//BUILD
if (webphone_api.GetBrowser() !== 'Chrome'
    || (webphone_api.GetBrowser() === 'Chrome' && webphone_api.GetBrowserVersion() < 42))
{
    document.write('<script type="text/javascript" src="js/lib/mwpdeploy.js"></script>');
}
document.write('<script data-main="js/lib/lib_softphone" src="js/lib/require.js"></script>');


/*function poll(events)
{
    if (typeof (events) !== 'undefined' && events !== null
            && (common_public.Trim(events)).indexOf('LOG') === 0)
    {
        common_public.PutToDebugLog(3, events);
    }else
    {
        common_public.PutToDebugLog(1, events);
    }
}*/


function webphonetojs (events) // receive notifications from webphone.jar
{
    try{
    webphone_public.webphone_started = true;
    window.webphone_pollstatus = false;
    
    common_public.ReceiveNotifications(events);

    } catch(err) { common_public.PutToDebugLogException(2, 'wphone webphonetojs: ' + err); }
}