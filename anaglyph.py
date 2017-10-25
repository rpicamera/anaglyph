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

def getDualPiImages():
# get image from master and slave pi
    requests.get("http://127.0.0.1/picam/cmd_pipe.php?cmd=im");
    requests.get("http://raspberrypi.local/picam/cmd_pipe.php?cmd=im");

    time.sleep(1)

    paternsize = 1000

    slave_media_dir  = 'http://raspberrypi.local/picam/media/'
    master_media_dir = 'http://127.0.0.1/picam/media/'
    urlpath = urlopen(slave_media_dir)
    string = urlpath.read().decode('utf-8')
    patern = re.compile('([^\"\']*\.jpg)');
    filelist = patern.findall(string[len(string)-paternsize:])
    filename = filelist[len(filelist)-4]
    rsp = urlopen(slave_media_dir+filename)
    slave_image = np.array(bytearray(rsp.read()), dtype=np.uint8)

    if _debug>=2:
        print(slave_media_dir + filename)
        output = open("img/slave.jpg","wb")
        rsc = urlopen(slave_media_dir+filename)
        output.write(rsc.read())
        output.close()

    urlpath = urlopen(master_media_dir)
    string = urlpath.read().decode('utf-8')
    filelist = patern.findall(string[len(string)-paternsize:])
    filename = filelist[len(filelist)-4]
    rsp = urlopen(master_media_dir+filename)
    master_image = np.array(bytearray(rsp.read()), dtype=np.uint8)

    if _debug>=2:
        print(master_media_dir+filename+'|')
        output = open("img/master.jpg","wb")
        rsc = urlopen(master_media_dir+filename)
        output.write(rsc.read())
        output.close()

    return master_image,slave_image

def main():

    leftimg,rightimg = getDualPiImages()

    # create the anaglyph image
    output = anaglyph(leftimg,rightimg)

    # save them to the local
    time_name = time.strftime('%Y%m%d_%H%M%S',time.gmtime())
    img_name = "img/an_"+ time_name +".jpg"
    thumb_name = "img/thumb_an_"+time_name+".jpg"

    jpg = Image.fromarray(output.astype('uint8'), 'RGB')
    jpg.save(img_name,'JPEG')

    basewidth=100
    wpercent = (basewidth/float(jpg.size[0]))
    hsize = int((float(jpg.size[1])*float(wpercent)))
    jpg = jpg.resize((basewidth,hsize), Image.ANTIALIAS)
    jpg.save(thumb_name,'JPEG')

if __name__ == '__main__':
    main()
