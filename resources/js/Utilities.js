import { isRef } from "vue";
import moment from "moment-timezone";


const Utilities = {

    isLink: (stringLink) => {
        return (
            stringLink.endsWith(".png") ||
            stringLink.endsWith(".jpeg") ||
            stringLink.endsWith(".jpg")
        );
    },

    getFormattedDate: (date) => {
        const formattedDate = moment(date).format("YYYY-MM-DD");
        return formattedDate;
    },

}

export default Utilities;