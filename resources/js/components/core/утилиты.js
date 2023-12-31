import _ from "lodash";
import * as jose from 'jose'

class утилиты {

    static split_string(string) {
        return _.split(string, ',');
    }

    static decodeJwtHeader(credential) {
        const header = jose.decodeProtectedHeader(credential);
        return header;
    }

    static decodeJwt(credential) {
        const jwt = jose.decodeJwt(credential);
        return jwt;
    }

    static makeStringEnding(number, txt) {
        var reference = [2, 0, 1, 1, 1, 2];
        return txt[(number % 100 > 4 && number % 100 < 20) ? 2 : 
            reference[(number % 10 < 5) ? number % 10 : 5]];
    }

    static decodeImageType(image) {
        let split = image.split(';')[0].split('data:image/')[1];
        return split;
    }

    static convertTime(obj) {
        let time = null;

        if(obj.hours && !obj.minutes) {
            time = obj.hours + ' ' + this.makeStringEnding(obj.hours, ["час", "часа", "часов"])
            return time;
        }

        if(!obj.hours && obj.minutes) {
            time = obj.minutes + ' ' + this.makeStringEnding(obj.minutes, ["минута", "минуты", "минут"])
            return time;
        }

        if(obj.hours && obj.minutes) {
            console.log(obj)
            let avr = Math.round(obj.minutes / 60 * 100);
            avr = Number(String(avr).substring(0, String(avr).length - 1));
            if (avr > 0) {
                if (avr < 10) {
                    time = obj.hours + ',' + avr + ' ' + this.makeStringEnding(obj.hours, ["часа", "часа", "часов"])
                } else {
                    time = obj.hours+1 + ' ' + this.makeStringEnding(obj.hours+1, ["час", "часа", "часов"])
                }
            } else {
                time = obj.hours + ' ' + this.makeStringEnding(obj.hours, ["час", "часа", "часов"])
            }
            return time;
        }
    }

    static utf8_to_b64(str) {
        return window.btoa(unescape(encodeURIComponent(str)));
    }

    static b64_to_utf8(str) {
        return decodeURIComponent(escape(window.atob(str)));
    }

    static generateShareListToken(user, id) {
        let token = id + '_!' + JSON.stringify(user); 
        let encoded = this.utf8_to_b64(token);
        return encoded;
    }

    static decodeShareListToken(token) {
        let decoded = this.b64_to_utf8(token);
        console.log(decoded)
    }

    static getBGU(bgu_str) {
        let bgu_array = bgu_str.split(',')
        let bgu = {
            protein: +bgu_array[0],
            fat: +bgu_array[1],
            carbs: +bgu_array[2]
        }
        return bgu;
    }
}

export { утилиты };
