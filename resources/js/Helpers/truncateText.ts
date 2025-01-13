/**
 * Truncates a string to a specified length and appends ellipses if truncated.
 * @param text - The string to be truncated.
 * @param length - The maximum length of the string.
 * @returns The truncated string with ellipses if it exceeds the length.
 */
export function truncateText(text: string, length: number): string {
    if (text.length <= length || length <= 0) {
        return text;
    }
    return text.slice(0, length) + '...';
}
