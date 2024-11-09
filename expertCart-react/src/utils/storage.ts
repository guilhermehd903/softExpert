export const setItem = (key: string, value: string) => {
    localStorage.setItem(key, JSON.stringify(value));
}

export const getItem = (key: string) => {
    if (localStorage.getItem(key) != null) {
        return JSON.parse(localStorage.getItem(key) as string);
    }

    return false;
}

export const removeItem = (key: string) => {
    if (localStorage.getItem(key) != null) {
        localStorage.removeItem(key);
        return true;
    }

    return false;
}

export const isAuthenticated = () => getItem("session") || null;