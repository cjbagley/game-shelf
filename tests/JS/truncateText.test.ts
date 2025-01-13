import { truncateText } from '../../resources/js/Helpers/truncateText';
import { describe, expect, it } from 'vitest';

describe('truncateText', () => {
  it('should return the original text if it is within the length limit', () => {
    expect(truncateText('Hello, World!', 20)).toBe('Hello, World!');
  });

  it('should truncate the text and append ellipses if it exceeds the length limit', () => {
    expect(truncateText('This is a long string that needs to be truncated.', 20)).toBe('This is a long strin...');
  });

  it('should return an empty string if the input is an empty string', () => {
    expect(truncateText('', 10)).toBe('');
  });

  it('should return the original text if the length limit is zero', () => {
    expect(truncateText('Hello, World!', 0)).toBe('Hello, World!');
  });
});