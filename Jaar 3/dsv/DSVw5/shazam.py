from fprinter import FingerPrinter
import sys
from db import DB

DB_FILE = 'songdb.db'

def main(argv):
    fp = FingerPrinter()
    if len(argv) == 1:
        help()
        return
    if argv[1] == 'add' and len(argv) == 4:
        add_song(argv[2], argv[3])
        return
    if argv[1] == 'find' and len(argv) == 3:
        s, h = find_song(argv[2])
        if s and h:
            print("I think it's song '{}', it matched {} times in my database.".format(s,h))
        else:
            print("We could not find any hits, perhaps you can add the song.")
        return
    help()

def help():
    print('DSV week 5: Shazam')
    print('Sander Hansen, Jan Schutte, Bas van Berckel')
    print('Usage:')
    print('\t shazam.py add [filename] [songname]')
    print('\t shazam.py find [filename]')

def add_song(filename, song):
    fp = FingerPrinter()
    database = DB(DB_FILE)
    prints = fp.fprint(filename)

    for p in prints:
        database.add_fprint(p, song)
    database.store()

def find_song(filename):
    fp = FingerPrinter()
    database = DB(DB_FILE)    
    
    prints = fp.fprint(filename)
    hits = {}
    for p in prints:
        matches = database.match_fprint(p)
        for m in matches:
            if m in hits:
                hits[m] += 1
            else:
                hits[m] = 1
    if len(hits) == 0:
        return (None, None)

    song = max(hits, key=hits.get)
    return (song, hits[song])

if __name__ == '__main__':
    main(sys.argv)
