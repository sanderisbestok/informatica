echo "1 node 8 mpi process 1000 10000000" >> timing.txt
prun -v -np 1 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000 10000000 >> timing.txt

echo "8 nodes 1 mpi process 1000 10000000" >> timing.txt
prun -v -np 8 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000 10000000 >> timing.txt

echo "8 nodes 8 mpi process 1000 10000000" >> timing.txt
prun -v -np 8 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000 10000000 >> timing.txt


echo "next" >> timing.txt
echo "1 node 8 mpi process 10000 10000000" >> timing.txt
prun -v -np 1 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000 10000000 >> timing.txt

echo "8 nodes 1 mpi process 10000 100000000" >> timing.txt
prun -v -np 8 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000 10000000 >> timing.txt

echo "8 nodes 8 mpi process 10000 100000000" >> timing.txt
prun -v -np 8 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000 10000000 >> timing.txt


echo "next" >> timing.txt
echo "1 node 8 mpi process 100000 1000000" >> timing.txt
prun -v -np 1 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 100000 1000000 >> timing.txt

echo "8 nodes 1 mpi process 100000 1000000" >> timing.txt
prun -v -np 8 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 100000 1000000 >> timing.txt

echo "8 nodes 8 mpi process 100000 1000000" >> timing.txt
prun -v -np 8 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 100000 1000000 >> timing.txt


echo "next" >> timing.txt
echo "1 node 8 mpi process 1000000 100000" >> timing.txt
prun -v -np 1 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000000 100000 >> timing.txt

echo "8 nodes 1 mpi process 1000000 100000" >> timing.txt
prun -v -np 8 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000000 100000 >> timing.txt

echo "8 nodes 8 mpi process 1000000 100000" >> timing.txt
prun -v -np 8 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 1000000 100000 >> timing.txt


echo "next" >> timing.txt
echo "1 node 8 mpi process 10000000 100000" >> timing.txt
prun -v -np 1 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000000 10000 >> timing.txt

echo "8 nodes 1 mpi process 10000000 100000" >> timing.txt
prun -v -np 8 -1 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000000 10000 >> timing.txt

echo "8 nodes 8 mpi process 10000000 100000" >> timing.txt
prun -v -np 8 -8 -sge-script $PRUN_ETC/prun-openmpi assign2_1 10000000 10000 >> timing.txt
