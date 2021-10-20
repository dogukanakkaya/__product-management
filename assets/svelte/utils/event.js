let timer;
export const debounce = (cb, timeout = 300) => {
    clearTimeout(timer)
    timer = setTimeout(cb, timeout)
}