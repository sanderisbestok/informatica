echo "1 node 1 mpi process 1000 10000000" >> timing.txt
prun -v -np 1 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000 10000000 >> timing.txt

echo "1 node 1 mpi process 10000 10000000" >> timing.txt
prun -v -np 1 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000 10000000 >> timing.txt

echo "1 node 1 mpi process 100000 1000000" >> timing.txt
prun -v -np 1 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 100000 1000000 >> timing.txt

echo "1 node 1 mpi process 1000000 100000" >> timing.txt
prun -v -np 1 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000000 100000 >> timing.txt

echo "1 node 1 mpi process 10000000 100000" >> timing.txt
prun -v -np 1 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000000 10000 >> timing.txt
