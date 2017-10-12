from PIL import Image
import numpy as np

# set the matrix as Optimized Anaglyphs
matleft = [[ 0.0, 0.7, 0.3],
           [ 0.0, 0.0, 0.0],
           [ 0.0, 0.0, 0.0]]

matright= [[ 0.0, 0.0, 0.0],
           [ 0.0, 1.0, 0.0],
           [ 0.0, 0.0, 1.0]]

def anaglyph(left, right):
    return np.dot(left ,matleft) + np.dot(right,matright)

def main():
    leftImgFile  = 'left.jpg'
    rightImgFile = 'right.jpg'
    leftimg  = Image.open(leftImgFile,'r')
    rightimg = Image.open(rightImgFile,'r')

    leftimg  = np.asarray(leftimg, dtype=np.uint8)
    rightimg = np.asarray(rightimg, dtype=np.uint8)

    output = anaglyph(leftimg,rightimg)

    jpg = Image.fromarray(output.astype('uint8'), 'RGB')
    jpg.save('output.jpg','JPEG')

if __name__ == '__main__':
    main()
