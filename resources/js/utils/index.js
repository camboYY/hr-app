import moment from "moment";

export function formatDate(newDate) {
    return moment(newDate).format("Y-MM-DD");
}

export function formatDateTime(newDate) {
    return moment(newDate).format("YYYY-MM-DD HH:mm:ss");
}

export function calculateAge(birthDate) {
    const ageDifMs = Date.now() - new Date(birthDate).getTime();
    const ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
    // return Math.abs(ageDate.getYear() - 1970);
    // return Math.floor(ageDifMs / (1000 * 60 * 60 * 24 * 365.25));
}

export function getDayOfWeek(date) {
    const days = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
    ];
    return days[new Date(date).getDay()];
}

export function getMonthName(date) {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    return months[new Date(date).getMonth()];
    // return new Date(date).toLocaleString("default", { month: "long" });
    // return new Intl.DateTimeFormat("en-US", { month: "long" }).format(date);
}
