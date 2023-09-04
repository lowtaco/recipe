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
}

export { утилиты };
