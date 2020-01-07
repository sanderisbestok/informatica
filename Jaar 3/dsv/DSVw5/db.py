import json
from pathlib import Path


class DB(object):

    """
    Database object to hold fingerprints with
      corresponding songs and timestamps
    Takes dbfile argument which is a filename
      holding a json string with database to build on
    """

    def __init__(self, dbfile=None):
        if dbfile:
            if Path(dbfile).exists():
                f = open(dbfile).read()
                self.database = json.loads(f)
            else:
                self.database = {}
            self.dbfile = dbfile
        else:
            self.database = {}

    def add_fprint(self, fprint, song):
        if fprint in self.database:
            if song not in self.database[fprint]: # If this is a set, computation would be faster
                self.database[fprint].append(song)
        else:
            self.database[fprint] = [song]

    def match_fprint(self, fprint):
        if fprint in self.database:
            return self.database[fprint]
        else:
            return []

    def store(self, dbfile=None):
        if(dbfile):
            f = open(dbfile, 'w')
        elif(self.dbfile):
            f = open(self.dbfile, 'w')
        else:
            raise ValueError("No filename supplied")

        f.write(json.dumps(self.database))

    def load(self, dbfile):
        f = open(dbfile).read()
        db = f.loads(f)
        for fp, val in db.items():
            if not self.database[fp]:
                self.database[fp] = []
            self.database[fp].extend(val)