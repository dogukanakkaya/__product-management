export const combinations = (list, n = 0, result = [], current = []) =>{
    if (n === list.length) {
        result.push(current)
    } else {
        list[n].forEach(item => combinations(list, n + 1, result, [...current, item]))
    }

    return result
}

export const reCombineWithExtra = (combinations, extra) => {
    const result = []

    combinations.forEach(combination => {
        result.push({
            items: combination,
            extra
        })
    })

    return result
}

export const bytesToSize = (bytes, decimals = 2) => {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

export const uploads = ({path, w = null, h = null, extension = 'webp'}) => {
    if (w || h) {
        return window.asset(`uploads/t/${path}-${w || ''}x${h || ''}.${extension}`)
    }

    return window.asset(`uploads/${path}.${extension}`)
}

export const isImage = extension => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp'].includes(extension)