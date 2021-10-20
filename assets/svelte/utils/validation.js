/**
 * Check for a required fields
 * false: true // This normally returns false with double exclamation mark but i modify it to return true on false value
 * true: true
 * null: false
 * undefined: false
 * 0: false
 * -0: false
 * NaN: false
 * '': false
 * @param value
 */
export const isRequired = value => value === false ? true : !!value